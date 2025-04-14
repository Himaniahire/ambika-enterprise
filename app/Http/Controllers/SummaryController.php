<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use Illuminate\Http\Request;
use App\Models\RegisterCompany;
use App\Models\CompanyServiceCode;
use App\Models\CategoryOfService;
use App\Models\SummaryProduct;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\ActivityLog;
use App\Exports\SummariesExport;
use App\Models\GstNumber;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PDF;
use File;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $columns = [
            0 => 'register_companies.companyname',
            1 => 'summaries.summ_date',
            2 => 'summaries.sum_no',
            3 => 'summaries.performa_no',
            4 => 'summaries.invoice_no',
            5 => 'summaries.total',
        ];

        $totalData = Summary::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $query = Summary::join('register_companies', 'summaries.company_id', '=', 'register_companies.id')
            ->select('summaries.*', 'register_companies.companyname');

        // Apply search filter if any
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('register_companies.companyname', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.summ_date', 'LIKE', "%{$search}%")
                    ->orWhereRaw("CONCAT(summaries.sum_no, '/', LPAD(summaries.id, 5, '0')) LIKE ?", ["%{$search}%"])
                    ->orWhere('summaries.performa_no', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.total', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        // Fetch the data with pagination and order by padded id
        $summaries = $query->offset($start)
            ->limit($limit)
            ->orderByRaw("LPAD(summaries.id, 4, '0') {$dir}")
            ->get();

        $data = [];
        $i = $start + 1;
        foreach ($summaries as $summary) {
            $nestedData = [
                'DT_RowIndex' => $i++,
                'companyname' => $summary->companyname,
                'summ_date' => strtoupper($summary->summ_date),
                'sum_no' => $summary->sum_no,
                'performa_no' => $summary->performa_no ?? "N/A",
                'invoice_no' => $summary->invoice_no ?? "N/A",
                'total' => $summary->total,
                'action' => '
                    <div class="dropdown">
                        <a class="btn btn-sm btn-soft-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
                            <i data-feather="settings"></i>
                        </a>
                        <ul class="dropdown-menu p-3">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <li><a href="' . route('summary.excel', $summary->id) . '" class="btn btn-sm btn-soft-primary"><img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;"></a></li>
                                <li><a href="' . route('summary.show', $summary->id) . '" class="btn btn-sm btn-soft-primary" target="_blank"><i data-feather="file-text"></i></a></li>
                                <li><a class="btn btn-sm btn-soft-danger" href="' . route('summary.edit', $summary->id) . '"><i data-feather="edit"></i></a></li>
                                <form action="' . route('summary.destroy', $summary->id) . '" method="POST" style="display:inline;">' . csrf_field() . method_field('DELETE') . '<button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to delete this item?\');"><a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a></button></form>
                            </div>
                        </ul>
                    </div>
                ',
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    return view('admin.accountant.summary.index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = RegisterCompany::where('com_status',1)->get();
        $categoryOfService = CategoryOfService::get();
        return view('admin.accountant.summary.add',compact('companies','categoryOfService'));
    }

    public function getSummaryNumber(Request $request)
    {
        $companyId = $request->input('company_id');

        // Determine financial year format (same logic as frontend)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        if ($currentMonth < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }

        $lastTwoDigitsStartYear = substr($startYear, -2);
        $lastTwoDigitsEndYear = substr($endYear, -2);
        $prefix = "{$lastTwoDigitsStartYear}-{$lastTwoDigitsEndYear}/SUM/";

        // Fetch the latest summary number for the company within the current financial year
        $latestSummary = Summary::where('sum_no', 'LIKE', "$prefix%")
            ->orderBy('id', 'desc')
            ->first();

        if ($latestSummary) {
            // Extract the numeric part and increment
            $lastNumber = (int) substr($latestSummary->sum_no, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return response()->json([
            'latest_number' => $newNumber
        ]);
    }


    public function getGstNumbers($companyId)
    {
        $gstNumbers = DB::table('gst_numbers')->where('company_id', $companyId)->get();

        return response()->json(['gstNumbers' => $gstNumbers]);
    }


    public function getSumByDateAndCompany(Request $request)
    {
        $company = $request->input('company_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $pos = Summary::select('register_companies.companyname', DB::raw('COUNT(summaries.id) AS sum_count'))
            ->join('register_companies', 'summaries.company_id', '=', 'register_companies.id')
            ->where('summaries.company_id', $company)
            ->whereBetween('summaries.created_at', [$startDate, $endDate])
            ->groupBy('register_companies.companyname')
            ->get();

        return response()->json($pos);
    }

    public function getPurchaseOrders($companyId)
    {
        $purchaseOrders = PurchaseOrder::where('company_id', $companyId)->get();
        return response()->json(['purchaseOrders' => $purchaseOrders]);
    }

    public function getServices($company_id)
    {
        $services = CompanyServiceCode::where('company_id',$company_id)->get(['id','service_code']);
        return response()->json($services);
    }

    public function getServiceByPO($po_no_id)
    {
        $poProducts = PurchaseOrderProduct::where('po_id', $po_no_id)->with('getServiceCode')->get();
        $services = $poProducts->map(function ($poProduct) {
            return $poProduct->getServiceCode;
        });

        return response()->json($services);
    }

    public function getServiceCodeDetails(Request $request, $id)
    {
        $companyServiceCode = CompanyServiceCode::find($id);
        if ($companyServiceCode) {
            return response()->json([
                'job_description' => $companyServiceCode->job_description,
                'uom' => $companyServiceCode->uom,
            ]);
        } else {
            return response()->json(['error' => 'Company Service Code not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'company_name' => 'required',
            'summary_duration' => 'required|string|max:255',
            'category_of_service' => 'required|string|max:255',
            'work_period' => 'required|string|max:255',
            'sum_date.*' => ['required','date_format:d-m-Y'],[
                'sum_date.required' => 'The summary date is required.',
                'sum_date.date_format' => 'The summary date must be in the format dd-mm-yyyy.', // Adjust as needed
            ],
            'length.*' => 'required|numeric',
            'width.*' => 'required|numeric',
            'height.*' => 'required|numeric',
            'nos.*' => 'required|numeric',
        ]);

        // Initialize a variable to store the file path
        $fileName = null;

        // Check if the document is present in the request
        if ($request->hasFile('document')) {
            $this->validate($request, [
                'document' => 'required',
            ]);
            // Get the original file name
            $fileName = $request->document->getClientOriginalName();

            // Move the document to the public directory and get the path
            $filePath = $request->document->move(public_path('summary_pdf'), $fileName);
        }

        $summaries = new Summary([
            "company_id" => $request->company_name,
            "gst_id" => $request->gst_id,
            "po_no_id" => $request->po_no_id,
            "jmr_no" => $request->jmr_no,
            "capex_no" => $request->capex_no,
            "work_contract_order_no" => $request->work_contract_order_no,
            "category_of_service_id" => $request->category_of_service,
            "work_period" => $request->work_period,
            "sum_no" => $request->sum_no,
            "summ_date" => $request->summary_duration,
            "com_unit" => $request->com_unit,
            "department" => $request->department,
            "plant" => $request->plant,
            "document" => $fileName,
            "total" => $request->total,
        ]);
        // dd($summaries);
        $summaries->save();
        $summary_id = DB::table('summaries')->orderBy('id','DESC')->select('id')->first();
        $summary_id = $summary_id->id;
        // foreach($request->job_description as $key => $descriptions)
        // {
        //     $summaryProduct['job_description']  = $descriptions;
        //     $summaryProduct['summary_id']       = $summary_id;
        //     $summaryProduct['po_id']            = $request->po_no_id;
        //     $summaryProduct['service_code_id']  = $request->service_code[$key];
        //     $summaryProduct['sum_date']         = $request->sum_date[$key];
        //     $summaryProduct['pg_no']            = $request->pg_no[$key];
        //     $summaryProduct['length']           = $request->length[$key];
        //     $summaryProduct['width']            = $request->width[$key];
        //     $summaryProduct['height']           = $request->height[$key];
        //     $summaryProduct['nos']              = $request->nos[$key];
        //     $summaryProduct['total_qty']        = $request->length[$key] * $request->width[$key] * $request->height[$key] * $request->nos[$key];
        //     SummaryProduct::create($summaryProduct);

        //     $total_amount =  $request->length[$key] * $request->width[$key] * $request->height[$key] * $request->nos[$key];
        //     $summaries->total += number_format(round($total_amount, 2), 2, '.', '');
        //     $summaries->update();
        // }

        foreach($request->job_description as $key => $descriptions)
        {
            // dd($request);
            $summaryProduct['job_description']  = $descriptions;
            $summaryProduct['summary_id']       = $summary_id;
            $summaryProduct['po_id']            = $request->po_no_id;
            $summaryProduct['service_code_id']  = $request->service_code_id[$key];
            $summaryProduct['service_code']     = $request->service_code[$key];
            $summaryProduct['sum_date']         = $request->sum_date[$key];
            $summaryProduct['pg_no']            = $request->pg_no[$key];
            $summaryProduct['uom']            = $request->uom[$key];
            $summaryProduct['length']           = $request->length[$key];
            $summaryProduct['width']            = $request->width[$key];
            $summaryProduct['height']           = $request->height[$key];
            $summaryProduct['nos']              = $request->nos[$key];
            $summaryProduct['total_qty']        = $request->length[$key] * $request->width[$key] * $request->height[$key] * $request->nos[$key];

            SummaryProduct::create($summaryProduct);

            $total_amount =  $request->length[$key] * $request->width[$key] * $request->height[$key] * $request->nos[$key];
            $summaries->total += number_format(round($total_amount, 2), 2, '.', '');

            $summaries->update();
        }


        return redirect('admin/accountant/summary')->with('success','Summary Generated Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orders = CompanyServiceCode::orderBy('order_no', 'asc')->distinct()->pluck('order_no')->toArray();

        $summaries = Summary::with('summaryProducts','companyServiceCode')->find($id);
        // dd($summaries);

        $descData = SummaryProduct::join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id')
            ->whereIn('company_service_codes.order_no', $orders)
            ->where('summary_products.summary_id', $id)
            ->select('summary_products.job_description', 'company_service_codes.order_no', 'company_service_codes.uom')  // Add 'uom' field here
            ->distinct()
            ->orderBy('company_service_codes.order_no', 'asc')
            ->get()
            ->toArray();
        $i = 1;
        $descriptionArr = [];
        $uomArr = [];

        foreach ($descData as $descDataKey => $descDataVal) {
            $descriptionArr[] = $descDataVal['job_description'];
            $uomArr[] = $descDataVal['uom'];
        }

        $data = compact('summaries', 'i', 'descriptionArr', 'uomArr');

        $pdf = PDF::loadView('admin.accountant.summary.show', $data)->setPaper('A3', 'landscape');

        return $pdf->stream($summaries->sum_no . '.pdf');

        return view('admin.accountant.summary.show');

    }

    public function exportExcel($id)
    {
        $orders = CompanyServiceCode::orderBy('order_no', 'asc')->distinct()->pluck('order_no')->toArray();
        $summaries = Summary::with('summaryProducts')->find($id);

        $descData = SummaryProduct::join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id')
                ->whereIn('company_service_codes.order_no', $orders)
                ->where('summary_products.summary_id', $id)
                ->select('summary_products.job_description', 'company_service_codes.order_no')
                ->distinct()
                ->orderBy('company_service_codes.order_no', 'asc')
                ->get()
                ->toArray();

        $i = 1;
        $descriptionArr = [];
        // Count the distinct job descriptions
        $colspan = count($descData);
        // dd($colspan);

        // Calculate the total colspan
        $totalColspan = $colspan + $colspan + 4 * $colspan + 3;
        // dd($totalColspan);

        foreach ($descData as $descDataKey => $descDataVal) {
            $descriptionArr[] = $descDataVal['job_description'];
        }

        $data = compact('summaries', 'i', 'descriptionArr','totalColspan');

        $filename = $summaries->sum_no . '_00' . $summaries->id . '.xlsx';
        $filename = str_replace(['/', '\\'], '_', $filename); // Replace '/' and '\' with '_'

        return Excel::download(new SummariesExport($data), $filename);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $summaries = Summary::find($id);
        $companies = RegisterCompany::get();
        $products = SummaryProduct::with('companyServiceCode')->where('summary_id',$id)->get();
        $categoryOfService = CategoryOfService::get();
        $gstNumbers = GstNumber::get();
        $poNumbers = PurchaseOrder::select('purchase_orders.id', 'purchase_orders.po_no')
            ->join('summaries', 'purchase_orders.company_id', '=', 'summaries.company_id')
            ->distinct()
            ->get();
        $i = 0;

        $comGstNum = Summary::with('getGST')->get();

        $poServiceCodes = DB::table('summary_products')
            ->join('summaries', 'summary_products.summary_id', '=', 'summaries.id')
            ->join('purchase_orders', 'summaries.po_no_id', '=', 'purchase_orders.id')
            ->join('company_service_codes', 'purchase_orders.company_id', '=', 'company_service_codes.company_id')
            ->select('company_service_codes.id', 'company_service_codes.service_code')
            ->where('summary_products.summary_id', $id)
            ->distinct()
            ->get();

        $companyServiceCodes = DB::table('summary_products')
            ->join('summaries', 'summary_products.summary_id', '=', 'summaries.id')
            ->join('company_service_codes', 'summaries.company_id', '=', 'company_service_codes.company_id')
            ->select('company_service_codes.id', 'company_service_codes.service_code')
            ->where('summary_products.summary_id', $id)
            ->distinct()
            ->get();

        return view('admin.accountant.summary.edit',compact('summaries','gstNumbers','comGstNum','companies','products','i','categoryOfService','poNumbers','poServiceCodes','companyServiceCodes'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'summary_duration' => 'required|string|max:255',
        'category_of_service' => 'required|string|max:255',
        'work_period' => 'required|string|max:255',
        'sum_date.*' => ['required', 'date_format:d-m-Y'],
        'length.*' => 'required|numeric',
        'width.*' => 'required|numeric',
        'height.*' => 'required|numeric',
        'nos.*' => 'required|numeric',
    ]);

    $summaries = Summary::findOrFail($id);

    if ($request->hasFile("document")) {
        if (File::exists(public_path("summary_pdf/" . $summaries->document))) {
            File::delete(public_path("summary_pdf/" . $summaries->document));
        }
        $file = $request->file("document");
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path("/summary_pdf"), $fileName);
        $summaries->document = $fileName;
    }

    $summaries->update([
        'company_id' => $request->company_name,
        'gst_id' => $request->gst_id,
        'po_no_id' => $request->po_no_id,
        'com_unit' => $request->com_unit,
        'sum_no' => $request->sum_no,
        'summ_date' => $request->summary_duration,
        'department' => $request->department,
        'plant' => $request->plant,
        'uom' => $request->uom,
        'jmr_no' => $request->jmr_no,
        'capex_no' => $request->capex_no,
        'work_contract_order_no' => $request->work_contract_order_no,
        'category_of_service_id' => $request->category_of_service,
        'work_period' => $request->work_period,
        'total' => $request->total,
    ]);

    DB::table('summary_products')->where('summary_id', $summaries->id)->delete();

    $total_amount = 0;

    for ($key = 0; $key < count($request->job_description); $key++) {
        $summaryProduct = [
            'summary_id' => $summaries->id,
            'job_description' => $request->job_description[$key],
            'sum_date' => $request->sum_date[$key],
            'pg_no' => $request->pg_no[$key],
            'po_id' => $request->po_no_id,
            'service_code_id' => $request->service_code_id[$key],
            'service_code' => $request->service_code[$key],
            'length' => $request->length[$key],
            'width' => $request->width[$key],
            'height' => $request->height[$key],
            'nos' => $request->nos[$key],
            'total_qty' => $request->length[$key] * $request->width[$key] * $request->height[$key] * $request->nos[$key],
        ];

        $summaryProductModel = SummaryProduct::updateOrCreate(
            ['summary_id' => $summaries->id, 'id' => $request->sr_no[$key] ?? null],
            $summaryProduct
        );

        $total_amount += $summaryProductModel->total_qty;
    }

    $summaries->total = number_format($total_amount, 2, '.', '');
    $summaries->save();

    $serviceCodeIds = SummaryProduct::where('summary_id', $id)->distinct()->pluck('service_code_id');

    $totalQty = 0;
    $totalPriceTotal = 0;
    $totalGstAmount = 0;

    foreach ($serviceCodeIds as $serviceCodeId) {
        $serviceTotalQty = SummaryProduct::where('summary_id', $id)
            ->where('service_code_id', $serviceCodeId)
            ->sum('total_qty');

        $serviceCodeData = CompanyServiceCode::find($serviceCodeId);

        if ($serviceCodeData) {
            $price = $serviceCodeData->price;
            $servicePriceTotal = $serviceTotalQty * $price;
            $taxRate = $summaries->tax ?? 0;
            $serviceGstAmount = $servicePriceTotal + (($servicePriceTotal * $taxRate) / 100);

            $totalQty += $serviceTotalQty;
            $totalPriceTotal += $servicePriceTotal;
            $totalGstAmount += $serviceGstAmount;

            SummaryProduct::where('summary_id', $id)
                ->where('service_code_id', $serviceCodeId)
                ->update(['price' => $price]);
        }
    }

    $summaries->update([
        'gst_type' => $summaries->gst_type,
        'tax' => $taxRate,
        'gst_amount' => $totalGstAmount,
        'price_total' => $totalPriceTotal,
    ]);

    return back()->with('success', 'Summary updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $summary = DB::table('summaries')->where('id', $id)->first();

        if (!$summary) {
            return redirect()->back()->with('error', 'Summary not found.');
        }

        DB::table('summary_products')->where('summary_id', $id)->delete();

        DB::table('summaries')->where('id', $id)->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted',
            'entity_type' => 'Summary',
            'entity_id' => $summary->id,
            'details' => 'Summary deleted with ' . $summary->sum_no . '/' . str_pad($summary->id, 5, '0', STR_PAD_LEFT)
        ]);

        return redirect()->back()->with('success', 'Summary Deleted Successfully.');
    }


    public function productDestroy($id)
    {
        $product = SummaryProduct::find($id);

        if ($product) {
            // Store the product's quantity before deletion
            $productQuantity = $product->total_qty;
            $summaryId = $product->summary_id;

            // Delete the product
            $product->delete();

            // Recalculate the total quantity in summary_products for the related summary_id
            $totalQty = SummaryProduct::where('summary_id', $summaryId)->sum('total_qty');

            // Update the total in the summaries table
            $summary = Summary::find($summaryId);
            if ($summary) {
                $summary->total = $totalQty;
                $summary->save();
            }

            return response()->json(['success' => 'Summary Product Deleted Successfully.']);
        }

        return response()->json(['success' => 'Summary Product Not Found.']);
    }

    public function deletesummarydocument($id)
    {
        $summaries = Summary::findOrFail($id)->document;
        if (File::exists("summary_pdf/" . $summaries)) {
            File::delete("summary_pdf/" . $summaries);
        }
        return back();
    }
}
