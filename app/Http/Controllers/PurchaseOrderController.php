<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\RegisterCompany;
use  App\Models\PurchaseOrderProduct;
use  App\Models\CompanyServiceCode;
use Illuminate\Http\Request;
use App\Rules\DateFormat;
use Carbon\Carbon;
use DB;
use File;


class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrder = PurchaseOrder::get();
        return view('admin.accountant.purchase_order.index',compact('purchaseOrder'));
    }

    public function getPurchaseOrderData(Request $request)
    {
        $columns = [
            0 => 'purchase_orders.po_no',
            1 => 'purchase_orders.po_date',
            2 => 'purchase_orders.total',
            3 => 'getCompany.companyname',
        ];

        $totalData = PurchaseOrder::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $purchaseOrders = PurchaseOrder::join('register_companies', 'purchase_orders.company_id', '=', 'register_companies.id')
                ->select('purchase_orders.*', 'register_companies.companyname')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $purchaseOrders = PurchaseOrder::join('register_companies', 'purchase_orders.company_id', '=', 'register_companies.id')
                ->select('purchase_orders.*', 'register_companies.companyname')
                ->where(function ($query) use ($search) {
                    $query->where('register_companies.companyname', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.po_no', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.po_date', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.total', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = PurchaseOrder::join('register_companies', 'purchase_orders.company_id', '=', 'register_companies.id')
                ->where(function ($query) use ($search) {
                    $query->where('register_companies.companyname', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.po_no', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.po_date', 'LIKE', "%{$search}%")
                        ->orWhere('purchase_orders.total', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];
        $i = $start + 1;
        if (!empty($purchaseOrders)) {
            foreach ($purchaseOrders as $order) {
                $nestedData['DT_RowIndex'] = $i++;
                $nestedData['company_name'] = $order->companyname;
                $nestedData['po_no'] = $order->po_no;
                $nestedData['po_date'] = $order->po_date ? Carbon::parse($order->po_date)->format('d-m-Y') : '';
                $nestedData['total'] = $order->total;
                $nestedData['action'] = '
                    <ul class="list-unstyled hstack gap-1 mb-0">
                        <li>
                            <a class="btn btn-sm btn-soft-primary" href="' . route('purchase_order.edit', $order->id) . '">
                                <i data-feather="edit"></i>
                            </a>
                        </li>
                        <form action="' . route('purchase_order.destroy', $order->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to delete this item?\');">
                                <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                            </button>
                        </form>
                    </ul>
                ';
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function report()
    {
        $companies = RegisterCompany::get();
        return view('admin.accountant.purchase_order.report',compact('companies'));
    }

    public function getPOByDateAndCompany(Request $request)
    {
        $company = $request->input('company_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $pos = PurchaseOrder::select('register_companies.companyname','purchase_orders.*')
            ->join('register_companies', 'purchase_orders.company_id', '=', 'register_companies.id')
            ->where('purchase_orders.company_id', $company)
            ->whereBetween('purchase_orders.created_at', [$startDate, $endDate])
            ->groupBy('register_companies.companyname',
                    'purchase_orders.*')
            ->get();

        return response()->json($pos);
    }

    public function getServiceCodeDetails(Request $request, $id)
    {

        $companyServiceCode = CompanyServiceCode::find($id);
        if ($companyServiceCode) {
            return response()->json([
                'job_description' => $companyServiceCode->job_description,
                'price' => $companyServiceCode->price,
                'uom' => $companyServiceCode->uom,
            ]);
        } else {
            return response()->json(['error' => 'Company Service Code not found'], 404);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = RegisterCompany::where('com_status',1)->get();
        return view('admin.accountant.purchase_order.add',compact('companies'));
    }

    public function getServiceCodes($companyId)
    {
        $services = CompanyServiceCode::where('company_id',$companyId)->get(['id','service_code']);
        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'company_name' => 'required',
            'po_no' => 'required|string|max:255|unique:purchase_orders,po_no',
            'po_date' => 'required',
            'service_code.*' => 'required|string|max:255',
            'qty.*' => 'required|numeric',
        ], [
            'company_name.required' => 'The company name is required.',
            'po_no.required' => 'The PO number is required.',
            'po_date.required' => 'The PO date is required.',
            'po_date.date_format' => 'The PO date must be in the format dd-mm-yyyy.',
            'service_code.*.required' => 'The service code is required.',
            'qty.*.required' => 'The quantity is required.',
            'qty.*.numeric' => 'The quantity must be a number.',
            'qty.*.min' => 'The quantity must be at least 1.'
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
            $filePath = $request->document->move(public_path('po_pdf'), $fileName);
        }

        // Create a new PurchaseOrder instance
        $purchaseOrder = new PurchaseOrder([
            "company_id" => $request->company_name,
            "po_no" => $request->po_no,
            "po_date" => $request->po_date,
            "contact_name" => $request->contact_name,
            "contact_num" => $request->contact_num,
            "document" => $fileName, // Store the file name in the database
            "total" => $request->total,
        ]);

        // Save the PurchaseOrder instance to the database
        $purchaseOrder->save();
        $purchaseOrder_id = DB::table('purchase_orders')->orderBy('id','DESC')->select('id')->first();
        $purchaseOrder_id = $purchaseOrder_id->id;
        foreach($request->job_description as $key => $descriptions)
        {
            $purchaseOrderProduct['job_description']     = $descriptions;
            $purchaseOrderProduct['po_id']           = $purchaseOrder_id;
            $purchaseOrderProduct['service_code_id']    = $request->service_code[$key];
            $purchaseOrderProduct['hsn_sac_code']    = $request->hsn_sac_code[$key];
            $purchaseOrderProduct['uom']             = $request->uom[$key];
            $purchaseOrderProduct['qty']             = $request->qty[$key];
            $purchaseOrderProduct['price']            = $request->price[$key];
            $purchaseOrderProduct['total_amount']    = $request->qty[$key] * $request->price[$key];
            PurchaseOrderProduct::create($purchaseOrderProduct);

            $total_amount =  $request->qty[$key] * $request->price[$key];
            $purchaseOrder->total += number_format($total_amount, 2, '.', '');
            $purchaseOrder->update();
        }
        return redirect('admin/accountant/purchase_order')->with('success','Purchase Order Generated Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $companies = RegisterCompany::get();
        $serviceCodes = DB::table('purchase_order_products')
        ->join('purchase_orders', 'purchase_order_products.po_id', '=', 'purchase_orders.id')
        ->join('company_service_codes', 'purchase_orders.company_id', '=', 'company_service_codes.company_id')
        ->select('purchase_orders.company_id', 'company_service_codes.id AS service_code_id', 'company_service_codes.service_code')
        ->where('purchase_orders.id', $id)
        ->groupBy('purchase_orders.company_id', 'company_service_codes.id', 'company_service_codes.service_code')
        ->get();
        // dd($serviceCodes);
        $products = PurchaseOrderProduct::where('po_id',$id)->get();
        return view('admin.accountant.purchase_order.edit',compact('purchaseOrder','companies','products','serviceCodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'po_no' => 'required|string|max:255',
            'po_date' => ['required'],[
                'po_date.required' => 'The PO date is required.',
            ],
            'service_code.*' => 'required|string|max:255',
            'qty.*' => 'required|numeric',
        ]);

        $purchaseOrder = PurchaseOrder::find($id);
        if ($request->hasFile("document")) {
            if (File::exists("po_pdf/" . $purchaseOrder->document)) {
                File::delete("po_pdf/" . $purchaseOrder->document);
            }
            $file = $request->file("document");
            $purchaseOrder->document = $file->getClientOriginalName();
            $file->move(\public_path("/po_pdf"), $purchaseOrder->document);
            $request['document'] = $purchaseOrder->document ?? null;
        }
        $purchaseOrder->company_id = $request->company_name;
        $purchaseOrder->po_no = $request->po_no;
        $purchaseOrder->po_date = $request->po_date;
        $purchaseOrder->contact_name = $request->contact_name;
        $purchaseOrder->contact_num = $request->contact_num;
        $purchaseOrder->total = $request->total;
        $purchaseOrder->update();

        if ($purchaseOrder) {
            $purchaseOrder_id = $purchaseOrder->id;
            $total_amount = 0;
            $purchaseOrderProducts = [];

                foreach ($request->sr_no as $key => $description) {
                    DB::table('purchase_order_products')->where('id', $request->sr_no[$key])->delete();
                }

            foreach($request->job_description as $key => $description){
                $purchaseOrderProduct = [
                    'po_id'      => $purchaseOrder_id,
                    'job_description'=> $request->job_description[$key],
                    'service_code_id'   => $request->service_code[$key],
                    'hsn_sac_code'   => $request->hsn_sac_code[$key],
                    'uom'      => $request->uom[$key],
                    'qty'     => $request->qty[$key],
                    'price'      => $request->price[$key],
                    'total_amount'    => $request->qty[$key] * $request->price[$key],
                ];
               $purchaseOrderProductModel = PurchaseOrderProduct::updateOrCreate(['id' => $request->sr_no[$key]], $purchaseOrderProduct);
               $total_amount +=  $purchaseOrderProductModel->total_amount;
               $purchaseOrderProduct[] = $purchaseOrderProductModel;
            }
            $purchaseOrder->total += number_format($total_amount, 2, '.', '');
            $purchaseOrder->save();
        }


        return redirect('admin/accountant/purchase_order')->with('success','Purchase Order Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $existsInSummaries = DB::table('summaries')
            ->where('po_no_id', $id)
            ->exists();

        if ($existsInSummaries) {
            // If it exists in the summaries table, return an error message
            return redirect()->back()->with('error', 'Cannot delete purchase order as it exists in summaries.');
        } else {
            // Proceed with deletion if it does not exist in the summaries table
            DB::table('purchase_order_products')->where('po_id', $id)->delete();
            DB::table('purchase_orders')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Purchase Order Deleted Successfully.');
        }
    }

    public function productDestroy($id)
    {
        $product = PurchaseOrderProduct::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['success' => 'Purchase Order Product Deleted Successfully.']);
        }

        return response()->json(['success' => 'Purchase Order Product Not Found.']);
    }

    public function deletepodocument($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id)->document;
        if (File::exists("po_pdf/" . $purchaseOrder)) {
            File::delete("po_pdf/" . $purchaseOrder);
        }
        return back();
    }
}
