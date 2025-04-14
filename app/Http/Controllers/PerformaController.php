<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summary;
use App\Models\SummaryProduct;
use App\Models\CategoryOfService;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\CompanyServiceCode;
use App\Models\RegisterCompany;
use App\Models\Invoice;
use App\Models\Performa;
use Illuminate\Support\Facades\File;
use App\Exports\PerformaExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use DB;
use PDF;

class PerformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'register_companies.companyname',
                1 => 'summaries.performa_date',
                2 => 'summaries.performa_no',
                3 => 'summaries.sum_no',
                4 => 'summaries.invoice_no',
                5 => 'summaries.gst_amount' ,
                6 => 'summaries.invoice_status'
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $orderColumnIndex = $request->input('order.0.column');
            $order = $columns[$orderColumnIndex];
            $dir = $request->input('order.0.dir');
            $search = $request->input('search.value');
            $statusFilter = $request->input('performa_status'); // Get the status filter from the request

            // Build the query with the status filter
            $query = Summary::with('getCompany')
                ->when($statusFilter, function ($q) use ($statusFilter) {
                    // If a status is selected, filter based on that status
                    $q->where('performa_status', $statusFilter);
                })
                ->where(function ($q) {
                    // Default status filter (Complete, Pending, Cancel)
                    $q->where('performa_status', '=', 'Complete')
                    ->orWhere('performa_status', '=', 'Pending')
                    ->orWhere('performa_status', '=', 'Cancel');
                });

            $search = trim($search);
            // Add search filter if there's a search term
            if (!empty($search)) {
                $query->where(function($query) use ($search) {
                    $query->where('performa_no', 'LIKE', "%{$search}%")
                        ->orWhereRaw("CONCAT(sum_no, '/', LPAD(id, 5, '0')) LIKE ?", ["%{$search}%"])
                        ->orWhere('invoice_no', 'LIKE', "%{$search}%")
                        ->orWhereHas('getCompany', function($q) use ($search) {
                            $q->where('companyname', 'LIKE', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $totalFiltered = $totalData;

            // Apply pagination and ordering
            $performa = $query->offset($start)
                            ->limit($limit)
                            ->orderByRaw('RIGHT(performa_no, 4) ASC')
                            ->get();

            if (!empty($search)) {
                $totalFiltered = $query->count();
            }

            // Prepare data for the DataTable
            $data = [];
            $i = $start + 1;

            foreach ($performa as $item) {

                $statusClass = '';
                $statusColor = 'white'; // Default color

                if ($item->performa_status == 'Complete') {
                    $statusClass = 'bg-success'; // green
                } elseif ($item->performa_status == 'Pending') {
                    $statusClass = 'bg-warning'; // yellow
                } elseif ($item->performa_status == 'Cancel') {
                    $statusClass = 'bg-danger'; // red
                } else {
                    $statusClass = 'bg-secondary'; // fallback
                }

                $xlsButton = !empty($item->performa_no) ?
                '<a href="' . route('performa.excel', $item->id) . '" class="btn btn-sm btn-soft-primary" onclick="showToastrMessage(\'Excel file is being downloaded!\')">
                    <img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;">
                </a>'
                : '<a href="javascript:void(0);" class="btn btn-sm btn-soft-danger" onclick="showToastrMessage(\'Performa not available\')">
                    <img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;">
                </a>';

                $pdfButton = !empty($item->performa_no) ?
                '<a href="' . route('performa.show', $item->id) . '" target="_blank" class="btn btn-sm btn-soft-primary" onclick="showToastrMessage(\'PDF file is being downloaded!\')">
                    <i data-feather="file-text"></i>
                </a>'
                : '<a href="javascript:void(0);" class="btn btn-sm btn-soft-danger" onclick="showToastrMessage(\'Performa not available\')">
                    <i data-feather="file-text"></i>
                </a>';

                $data[] = [
                    'DT_RowIndex' => $i++,
                    'company_name' => $item->getCompany->companyname,
                    'performa_date' => $item->performa_date ?? 'N/A',
                    'performa_no' => $item->performa_no ?? 'N/A',
                    'sum_no' => $item->sum_no,
                    'invoice_no' => $item->invoice_no ?? 'N/A',
                    'gst_amount' => $item->gst_amount ?? '0.00',
                    'status' => '<div class="badge ' . $statusClass . ' rounded-pill">' . $item->performa_status . '</div>',
                    'performa_status' => '<input type="hidden" class="performa_status" value="' . $item->performa_status . '">',
                    'action' => '
                        <div class="dropdown">
                            <a class="btn btn-sm btn-soft-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
                                <i data-feather="settings"></i>
                            </a>
                            <ul class="dropdown-menu p-3">
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    <li>' . $xlsButton . '</li>
                                    <li>' . $pdfButton . '</li>
                                    <li>
                                        <a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#editPerformaModal_' . $item->id . '">
                                            <i data-feather="edit"></i>
                                        </a>

                                        <div class="modal fade" id="editPerformaModal_' . $item->id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitleEdit_' . $item->id . '" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleEdit_' . $item->id . '">Update Performa Details</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="' . route('performa.update', $item->id) . '" method="POST">
                                                            ' . csrf_field() . '
                                                            ' . method_field('PUT') . '
                                                            <div class="row gx-3 mb-3">
                                                                <div class="col-6 col-md-6">
                                                                    <label class="small mb-1" for="performa_date_' . $item->id . '">Performa Date <span class="text-danger">*</span></label>
                                                                    <input class="form-control" id="performa_date_' . $item->id . '" type="text" name="performa_date" value="' . $item->performa_date . '" />
                                                                    <span id="error-performa-date-message" class="error"></span>
                                                                </div>
                                                                <div class="col-6 col-md-6">
                                                                    <label class="small mb-1" for="performa_no_' . $item->id . '">Performa No <span class="text-danger">*</span></label>
                                                                    <input class="form-control" id="performa_no_' . $item->id . '" type="text" name="performa_no" value="' . $item->performa_no . '"
                                                                        ' . (auth()->user()->role_id == 1 ? '' : 'readonly') . '/>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary" type="submit">Update Performa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <form action="' . route('performa.destroy', $item->id) . '" method="POST">
                                            ' . csrf_field() . '
                                            ' . method_field('DELETE') . '
                                            <button type="submit" class="btn btn-sm btn-soft-danger" style="padding-left: 22px;" onclick="return confirm(\'Are you sure you want to delete this item?\');" style="border: none; background: transparent; padding: 0px;">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to cancel this item?\');">
                                            <a class="btn btn-sm btn-soft-danger" href="' . route('performa.cancel', $item->id) . '">
                                                <i data-feather="x-circle"></i>
                                            </a>
                                        </button>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    ',
                ];
            }

            // Prepare and return the JSON response for DataTables
            $json_data = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            ];

            return response()->json($json_data);
        }

        return view('admin.accountant.performa.index');
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            $performa = Summary::where('performa_status', 'Pending')->with('getCompany')->orderByRaw('RIGHT(performa_no, 4) ASC');

            return DataTables::of($performa)
                ->addIndexColumn()
                ->addColumn('company_name', function($row){
                    return $row->getCompany->companyname;
                })
                ->addColumn('performa_date', function($row){
                    return $row->performa_date ?? 'N/A';
                })
                ->addColumn('performa_no', function($row){
                    return $row->performa_no ?? 'N/A';
                })
                ->addColumn('summary_no', function($row){
                    return $row->sum_no . '/' . str_pad($row->id, 5, '0', STR_PAD_LEFT);
                })

                ->addColumn('invoice_no', function($row){
                    return $row->invoice_no ?? 'N/A';
                })
                ->addColumn('total', function($row){
                    return $row->gst_amount;
                })
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-unstyled hstack gap-1 mb-0">';
                    $btn .= '<li><a href="'.route('performa.excel', $row->id).'" class="btn btn-sm btn-soft-primary"><img src="'.asset('admin_assets/index_icon/xls.png').'" alt="XLS" style="width: 15px;"></a></li>';
                    $btn .= '<li><a href="'.route('performa.show', $row->id).'" target="_blank" class="btn btn-sm btn-soft-primary"><i data-feather="file-text"></i></a></li>';
                    $btn .= '<li><a href="#" target="_blank" class="btn btn-sm btn-soft-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenterPerforma'.$row->id.'"><i data-feather="edit"></i></a></li>';
                    $btn .= '<li><form action="'.route('performa.destroy', $row->id).'" method="POST">'.csrf_field().method_field('DELETE').'<button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to delete this item?\');" ><a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a></button></form></li>';
                    $btn .= '</ul>';

                    // Modal code goes here
                    $btn .= '<div class="modal fade" id="exampleModalCenterPerforma'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Generate Performa Details</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="'.route('performa.update', $row->id).'" method="POST">
                                                '.csrf_field().method_field('PUT').'
                                                <!-- Form Row -->
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group -->
                                                    <div class="col-6 col-md-6">
                                                        <input type="hidden" name="company_id" value="'.$row->company_id.'">
                                                        <label class="small mb-1" for="inputFirstName">Performa Date <span class="text-danger">*</span></label>
                                                        <input class="form-control error-performa-date-message" id="performa_date" type="text" name="performa_date" value="'.$row->performa_date.'" />
                                                        <span id="error-performa-date-message" class="error"></span>
                                                    </div>
                                                    <div class="col-6 col-md-6" id="inputContainer">
                                                        <label class="small mb-1" for="inputFirstName">Tax <span class="text-danger">*</span></label>
                                                        <select class="form-control" id="tax" name="tax">
                                                            <option value="'.$row->tax.'">18%</option>
                                                            <option value="18">18%</option>
                                                            <option value="">0%</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Performa No <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="performa_no" type="text" name="performa_no" value="'.$row->performa_no.'"

                                                                readonly
                                                              />
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Update Performa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.accountant.performa.pending');
    }

    public function complete(Request $request)
    {
        if ($request->ajax()) {
            $performas = Summary::where('performa_status', 'Complete')->with('getCompany')->orderByRaw('RIGHT(performa_no, 4) ASC')->get();

            return datatables()->of($performas)
                ->addIndexColumn()
                ->addColumn('company_name', function($row) {
                    return $row->getCompany->companyname;
                })
                ->addColumn('performa_date', function($row) {
                    return $row->performa_date ?? 'N/A';
                })
                ->addColumn('performa_no', function($row) {
                    return $row->performa_no ?? 'N/A';
                })
                ->addColumn('sum_no', function($row){
                    return $row->sum_no . '/' . str_pad($row->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('invoice_no', function($row) {
                    return $row->invoice_no ?? 'N/A';
                })
                ->addColumn('gst_amount', function($row) {
                    return $row->gst_amount;
                })
                ->addColumn('action', function($row) {
                    $viewBtn = '<a href="' . route('performa.show', $row->id) . '" target="_blank" class="btn btn-sm btn-soft-primary"><i data-feather="file-text"></i></a>';
                    $deleteForm = '<form action="' . route('performa.destroy', $row->id) . '" method="POST" style="display:inline-block;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to delete this item?\');">
                                        <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                                    </button>
                                </form>';
                    return $viewBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.accountant.performa.complete');
    }

    public function report()
    {

    }

    public function getPerformaByDateAndCompany(Request $request)
    {
        $company = $request->input('company_id');
        $purchaseOrder = $request->input('po_no_id');
        $workContractOrderNo = $request->input('work_contract_order_no');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Performa::select('register_companies.companyname', 'purchase_orders.po_no','performas.*')
            ->join('register_companies', 'performas.company_id', '=', 'register_companies.id')
            ->leftJoin('purchase_orders', 'performas.po_no_id', '=', 'purchase_orders.id')
            ->where('performas.company_id', $company)
            ->where('performas.status', $status)
            ->whereBetween('performas.created_at', [$startDate, $endDate])
            ->when($purchaseOrder, function($query, $purchaseOrder) {
                return $query->where('performas.po_no_id', $purchaseOrder);
            })
            ->when($workContractOrderNo, function($query, $workContractOrderNo) {
                return $query->where('performas.work_contract_order_no', $workContractOrderNo);
            })
            ->groupBy(
                'register_companies.companyname',
                'purchase_orders.po_no',
                'performas.id',
                'performas.company_id',
                'performas.status',
                'performas.created_at',
                'performas.updated_at',
                'performas.po_no_id',
                'performas.unit',
                'performas.jmr_no',
                'performas.work_contract_order_no',
                'performas.plant',
                'performas.document',
                'performas.department',
                'performas.category_of_service_id',
                'performas.invoice_no',
                'performas.invoice_date',
                'performas.tax',
                'performas.work_period',
                'performas.total',
                'performas.gst_amount'
            )
            ->get();

        return response()->json($query);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $performas = Summary::find($id);
        $products = SummaryProduct::where('summary_id', $id)
        ->select('summary_products.price', 'summary_products.job_description', 'summary_products.service_code_id')
        ->selectRaw('SUM(summary_products.total_qty) as total_qty')
        ->join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id') // Adjust the table and column names as necessary
        ->groupBy('summary_products.service_code_id', 'summary_products.job_description', 'summary_products.price')
        ->distinct()
        ->orderBy('company_service_codes.service_code') // Order by service_code
        ->get();
        $purchaseOrder = SummaryProduct::where('summary_id',$id)->with('purchaseOrder')->first();
        $i = 1;
        $sub_total = 0;
        $word = $this->numberToWord($performas->gst_amount ?? 0);

        $data = compact('performas','products','i','sub_total','word','purchaseOrder');

        $pdf = PDF::loadView('admin.accountant.performa.show',$data);
        return $pdf->stream($performas->performa_no .'.pdf');

        return view('admin.accountant.performa.show',$data);
    }

    public function exportExcel($id)
    {
        $performas = Summary::find($id);

        $products = SummaryProduct::where('summary_id', $id)
        ->select('summary_products.price', 'summary_products.job_description', 'summary_products.service_code_id')
        ->selectRaw('SUM(summary_products.total_qty) as total_qty')
        ->join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id') // Adjust the table and column names as necessary
        ->groupBy('summary_products.service_code_id', 'summary_products.job_description', 'summary_products.price')
        ->distinct()
        ->orderBy('company_service_codes.service_code') // Order by service_code
        ->get();

        $purchaseOrder = SummaryProduct::where('summary_id', $id)->with('purchaseOrder')->first();

        $i = 1;
        $sub_total = 0;
        $word = $this->numberToWord($performas->gst_amount ?? 0);

        $data = compact('performas', 'products', 'i', 'sub_total', 'word', 'purchaseOrder');

        $filename = $performas->performa_no .'.xlsx';
        $filename = str_replace(['/', '\\'], '_', $filename); // Replace '/' and '\' with '_'

        return Excel::download(new PerformaExport($data), $filename);
    }

    public function numberToWord($number = '')
{
    if (!is_numeric($number)) {
        return 'Invalid Number';
    }

    $decimal = round(($number - floor($number)) * 100); // Proper rounding
    $no = floor($number);
    $digits_length = strlen($no);
    $i = 0;
    $str = [];
    
    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 
        18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    ];
    
    $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = $no % $divider;
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;

        if ($number) {
            $counter = count($str);
            $plural = ($counter && $number > 9) ? '' : ''; // Removed plural 's'
            $hundred = ($counter == 1 && !empty($str[0])) ? ' and ' : '';

            if ($number < 21) {
                $str[] = $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            }
        } else {
            $str[] = null;
        }
    }

    $Rupees = implode('', array_reverse($str));
    
    // Handling decimals (Paise)
    $paise = '';
    if ($decimal > 0) {
        if ($decimal < 20) {
            $paise = $words[$decimal] . ' Paise';
        } else {
            $paise = $words[floor($decimal / 10) * 10] . ' ' . $words[$decimal % 10] . ' Paise';
        }
    }

    return trim(($Rupees ? $Rupees . 'Rupees ' : '') . $paise);
}


    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $request->validate([
            'performa_date' => ['required', 'date_format:d-m-Y'],
        ], [
            'performa_date.required' => 'The Performa date is required.',
            'performa_date.date_format' => 'The Performa date must be in the format dd-mm-yyyy.',
        ]);

        $performa = Summary::findOrFail($id);
        $companyId = $request->input('company_id');
        $company = RegisterCompany::findOrFail($companyId);

        if ($performa->performa_status === 'Cancel') {
            $performa->performa_status = 'Pending';
        }

        if (is_null($performa->performa_no)) {
           $lastPerforma = Summary::whereNotNull('performa_no')
            ->orderBy('created_at', 'desc')
            ->first();

            $lastNumber = 0;
            if ($lastPerforma) {
                preg_match('/(\d{4})$/', $lastPerforma->performa_no, $matches);
                $lastPerformaNumber = $matches ? intval($matches[0]) : 0;
                $lastNumber = max($lastNumber, $lastPerformaNumber);
            }

            $nextNumber = $lastNumber + 1;
            $formattedNumber = sprintf('%04d', $nextNumber);

            // Determine financial year
            $currentMonth = date('n');
            $currentYear = date('y');
            if ($currentMonth < 4) {
                $startYear = $currentYear - 1;
                $endYear = $currentYear;
            } else {
                $startYear = $currentYear;
                $endYear = $currentYear + 1;
            }

            // Generate the new performa number
            $performaNo = "{$startYear}-{$endYear}/PERFORMA/{$formattedNumber}";

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Auto-generated',
                'entity_type' => 'Performa No',
                'entity_id' => $performa->id,
                'details' => "Performa Auto-generated with {$performaNo}",
            ]);
        } else {
            $performaNo = $request->input('performa_no');

            // Extract the prefix and the last 4 digits
            $prefix = substr($performaNo, 0, 19); // "24-25/PERFORMA/GFL"
            $lastFour = substr($performaNo, -4);  // "0001"

            $performaExists = Summary::whereRaw("
                    LEFT(performa_no, ?) = ?
                    AND RIGHT(performa_no, 4) = ?",
                [strlen($prefix), $prefix, $lastFour]
            )
            ->where('id', '!=', $id)
            ->exists();

            if ($performaExists) {
                return back()->with('error', 'Performa number with this combination already exists.');
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Manually-generated',
                'entity_type' => 'Performa No',
                'entity_id' => $performa->id,
                'details' => "Performa Manually-generated with {$performaNo}",
            ]);
        }

        $serviceCodeIds = SummaryProduct::where('summary_id', $id)->distinct()->pluck('service_code_id');

        $totalQty = 0;
        $totalPriceTotal = 0;
        $totalGstAmount = 0;

        foreach ($serviceCodeIds as $serviceCodeId) {
            $serviceTotalQty = SummaryProduct::where('summary_id', $id)
                ->where('service_code_id', $serviceCodeId)
                ->sum('total_qty');

            // Get service_code and price from company_service_code table
            $serviceCodeData = CompanyServiceCode::find($serviceCodeId);

            if ($serviceCodeData) {
                $price = $serviceCodeData->price;
                $servicePriceTotal = $serviceTotalQty * $price;
                $taxRate = $request->tax;
                $serviceGstAmount = $servicePriceTotal + (($servicePriceTotal * $taxRate) / 100);

                // Accumulate totals
                $totalQty += $serviceTotalQty;
                $totalPriceTotal += $servicePriceTotal;
                $totalGstAmount += $serviceGstAmount;

                // Update price in summary_products table
                SummaryProduct::where('service_code_id', $serviceCodeId)->update(['price' => $price]);
            }
        }

        $performa->update([
            'gst_type' => $request->gst_type,
            'tax' => $request->tax,
            'performa_no' => $performaNo,
            'performa_date' => $request->performa_date,
            'gst_amount' => $totalGstAmount,
            'price_total' => $totalPriceTotal,
        ]);

        return back()->with('success', 'Performa Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $performa = Summary::find($id);

        // Check if the performa exists
        if (!$performa) {
            return response()->json(['message' => 'Performa not found'], 404);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted',
            'entity_type' => 'Performa No',
            'entity_id' => $performa->id,
            'details' => 'Performa deleted with ' . $performa->performa_no
        ]);

        // Set invoice_no and invoice_date to null
        $performa->performa_no = null;
        $performa->performa_date = null;
        $performa->price_total = null;
        $performa->gst_amount = null;

        // Save the changes
        $performa->save();

        return redirect()->back()->with('success','Performa Deleted Successfully.');
    }

    public function cancel($performaId)
    {
        $performa = Summary::findOrFail($performaId);

        $oldStatus = $performa->performa_status;
        $newStatus = 'Cancel';

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Status Changed',
            'entity_type' => 'Performa Status',
            'entity_id' => $performa->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'details' => "Performa status changed from $oldStatus to $newStatus"
        ]);

        $performa->performa_status = $newStatus;
        $performa->save();

        return redirect()->back()->with('success', 'Performa canceled successfully.');
    }

}
