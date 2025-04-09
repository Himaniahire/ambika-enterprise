<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use App\Models\Performa;
use App\Models\PerformaProduct;
use App\Models\PurchaseOrderProduct;
use App\Models\SummaryProduct;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\RegisterCompany;
use App\Models\CategoryOfService;
use App\Models\CompleteInvoice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $columns = [
                0 => 'register_companies.companyname',
                1 => 'summaries.invoice_date',
                2 => 'summaries.invoice_no',
                3 => 'summaries.sum_no',
                4 => 'summaries.performa_no',
                5 => 'purchase_orders.po_no',
                6 => 'summaries.total',
                7 => 'summaries.gst_amount',
                8 => 'summaries.invoice_status'
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $orderColumnIndex = $request->input('order.0.column');
            $order = $columns[$orderColumnIndex] ?? 'summaries.invoice_date'; // Default order column
            $dir = $request->input('order.0.dir', 'asc'); // Default order direction
            $search = $request->input('search.value');
            $statusFilter = $request->input('invoice_status');

            $query = Summary::with('getCompany')
                ->leftJoin('purchase_orders', 'summaries.po_no_id', '=', 'purchase_orders.id') // Ensure join if needed
                ->leftJoin('register_companies', 'summaries.company_id', '=', 'register_companies.id')
                ->select('summaries.*', 'purchase_orders.po_no', 'register_companies.companyname')
                ->when($statusFilter, function ($q) use ($statusFilter) {
                    $q->where('invoice_status', $statusFilter);
                })
                ->where(function ($q) {
                    $q->where('invoice_status', '=', 'Complete')
                    ->orWhere('invoice_status', '=', 'Pending')
                    ->orWhere('invoice_status', '=', 'Cancel');
                });


            // Apply Performa/Invoice Filter
            if ($request->has('per_inv_filter')) {
                if ($request->per_inv_filter == 'Performa') {
                    $query->whereNull('invoice_no'); // Show only Performa invoices
                } elseif ($request->per_inv_filter == 'Invoice') {
                    $query->whereNotNull('invoice_no'); // Show only actual invoices
                }
            }

            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
            }
            
            $search = trim($search);

            if (!empty($search)) {
                $query->where(function($query) use ($search) {
                    $query->where('purchase_orders.po_no', 'LIKE', "%{$search}%")
                          ->orWhere('summaries.invoice_no', 'LIKE', "%{$search}%")
                          ->orWhereRaw("CONCAT(summaries.sum_no, '/', LPAD(summaries.id, 5, '0')) LIKE ?", ["%{$search}%"])
                          ->orWhere('summaries.performa_no', 'LIKE', "%{$search}%")
                          ->orWhere('summaries.total', 'LIKE', "%{$search}%")
                          ->orWhere('summaries.gst_amount', 'LIKE', "%{$search}%")
                          ->orWhere('register_companies.companyname', 'LIKE', "%{$search}%");

                });
            }
            // dd($query);


            $totalData = $query->count();
            $totalFiltered = $totalData;

            $invoices = $query->offset($start)
                ->limit($limit)
                ->orderBy(DB::raw('RIGHT(summaries.invoice_no, 4)'), $dir)
                ->get();


            if (!empty($search)) {
                $totalFiltered = $query->count();
            }

            $data = [];
            $i = $start + 1;

            foreach ($invoices as $invoice) {

                $statusClass = '';
                $statusColor = 'white'; // Default color

                if ($invoice->invoice_status == 'Complete') {
                    $statusClass = 'status-complete';
                    $statusColor = '#00ff00';
                } elseif ($invoice->invoice_status == 'Pending') {
                    $statusClass = 'status-pending';
                    $statusColor = 'yellow';
                } elseif ($invoice->invoice_status == 'Cancel') {
                    $statusClass = 'status-cancel';
                    $statusColor = '#ff6868';
                }

                $xlsButton = !empty($invoice->invoice_no) ?
                '<a href="' . route('invoice.excel', $invoice->id) . '" class="btn btn-sm btn-soft-primary" onclick="showToastrMessage(\'Excel file is being downloaded!\')">
                    <img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;">
                </a>'
                : '<a href="javascript:void(0);" class="btn btn-sm btn-soft-danger" onclick="showToastrMessage(\'Invoice not available\')">
                    <img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;">
                </a>';

                $pdfButton = !empty($invoice->invoice_no) ?
                '<a href="' . route('invoice.show', $invoice->id) . '" target="_blank" class="btn btn-sm btn-soft-primary" onclick="showToastrMessage(\'PDF file is being downloaded!\')">
                    <i data-feather="file-text"></i>
                </a>'
                : '<a href="javascript:void(0);" class="btn btn-sm btn-soft-danger" onclick="showToastrMessage(\'Invoice not available\')">
                    <i data-feather="file-text"></i>
                </a>';

                $data[] = [
                    'DT_RowIndex' => $i++,
                    'company_name' => $invoice->getCompany->companyname ?? 'N/A',
                    'invoice_date' => \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y'),
                    'invoice_no' => $invoice->invoice_no,
                    'sum_no' => $invoice->sum_no,
                    'performa_no' => $invoice->performa_no,
                    'po_no' => $invoice->po_no,
                    'total' => $invoice->total,
                    'gst_amount' => $invoice->gst_amount,
                    'status' => '<span class="status" style="background-color: ' . $statusColor . '; color: white; color: #000000;font-weight: 500;padding: 2px 7px 5px 7px;border-radius: 17px;">' . $invoice->invoice_status . '</span>',
                    'invoice_status' => '<input type="hidden" class="invoice_status" value="' . $invoice->invoice_status . '">',
                    'action' => '
                        <ul class="list-unstyled hstack gap-1 mb-0">
                            <li>' . $xlsButton . '</li>
                            <li>' . $pdfButton . '</li>
                            <li>
                                <a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#completeInvoiceModal_' . $invoice->id . '">
                                    <i data-feather="check"></i>
                                </a>

                                <div class="modal fade" id="completeInvoiceModal_' . $invoice->id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitle_' . $invoice->id . '" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle_' . $invoice->id . '">Complete Invoice Details</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="' . route('complete.invoice') . '" method="POST" enctype="multipart/form-data">
                                                    ' . csrf_field() . '
                                                    <div class="row gx-3 mb-3">
                                                        <input type="hidden" name="invoice_no" value="' . $invoice->invoice_no . '">
                                                        <input type="hidden" name="invoice_id" value="' . $invoice->id . '" />
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="tds_' . $invoice->id . '">TDS</label>
                                                            <input class="form-control" id="tds_' . $invoice->id . '" type="text" name="tds" value="" />
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="retention_' . $invoice->id . '">Retention</label>
                                                            <input class="form-control" id="retention_' . $invoice->id . '" type="text" name="retention" value="" />
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="payment_receive_date_' . $invoice->id . '">Payment Receive Date</label>
                                                            <input class="form-control" id="payment_receive_date_' . $invoice->id . '" type="date" name="payment_receive_date" value="" />
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="payment_' . $invoice->id . '">Payment</label>
                                                            <input class="form-control" id="payment_' . $invoice->id . '" type="text" name="payment" value=""/>
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="penalty_' . $invoice->id . '">Penalty</label>
                                                            <input class="form-control" id="penalty_' . $invoice->id . '" type="text" name="penalty" value=""/>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Add Complete Invoice</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#editInvoiceModal_' . $invoice->id . '">
                                    <i data-feather="edit"></i>
                                </a>

                                <div class="modal fade" id="editInvoiceModal_' . $invoice->id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitleEdit_' . $invoice->id . '" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitleEdit_' . $invoice->id . '">Generate Invoice Details</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="' . route('invoice.update', $invoice->id) . '" method="POST">
                                                    ' . csrf_field() . '
                                                    ' . method_field('PUT') . '
                                                    <div class="row gx-3 mb-3">
                                                        <div class="col-6 col-md-6">
                                                            <input type="hidden" name="company_id" value="' . $invoice->company_id . '">
                                                            <label class="small mb-1" for="invoice_date_' . $invoice->id . '">Invoice Date <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="invoice_date_' . $invoice->id . '" type="date" name="invoice_date" value="' . $invoice->invoice_date . '" />
                                                            <span id="error-invoice-date-message" class="error"></span>
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <label class="small mb-1" for="invoice_no_' . $invoice->id . '">Invoice No <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="invoice_no_' . $invoice->id . '" type="text" name="invoice_no" value="' . $invoice->invoice_no . '"
                                                                ' . (auth()->user()->role_id == 1 ? '' : 'readonly') . ' />
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Invoice</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <form action="' . route('invoice.destroy', $invoice->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-soft-danger" style="padding-left: 22px;" onclick="return confirm(\'Are you sure you want to delete this Invoice ?\');" style="border: none; background: transparent; padding: 0px;">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </li>
                            <li>
                                <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to cancel this item?\');">
                                    <a class="btn btn-sm btn-soft-danger" href="' . route('invoice.cancel', $invoice->id) .'">
                                        <i data-feather="x-circle"></i>
                                    </a>
                                </button>
                            </li>
                        </ul>
                     ',
                ];
            }

            $json_data = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            ];

            return response()->json($json_data);
        }

        return view('admin.accountant.invoice.index');
    }

    public function pending()
    {
        $invoices = Summary::where('invoice_status', 'Pending')->orderByRaw('RIGHT(invoice_no, 4) ASC')->get();
        return view('admin.accountant.invoice.pending', compact('invoices'));
    }

    public function getInvoicePendingData(Request $request)
    {
        $columns = [
            0 => 'register_companies.companyname',
            1 => 'summaries.invoice_date',
            2 => 'summaries.invoice_no',
            3 => 'summaries.sum_no',
            4 => 'summaries.performa_no',
            5 => 'summaries.total',
            6 => 'summaries.gst_amount'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order.0.column');
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // Ensure $order is a valid index
        $orderColumn = isset($columns[$order]) ? $columns[$order] : $columns[0]; // Default to the first column

        // Base query
        $query = Summary::join('register_companies', 'summaries.company_id', '=', 'register_companies.id')
            ->select([
                'summaries.id',
                'summaries.company_id',
                'summaries.invoice_date',
                'summaries.invoice_no',
                'summaries.sum_no',
                'summaries.performa_no',
                'summaries.total',
                'summaries.gst_amount',
                'register_companies.companyname as company_name'
            ])
            ->where('summaries.invoice_status', 'Pending');

        // Apply search filter if present
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('register_companies.companyname', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.sum_no', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.performa_no', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.total', 'LIKE', "%{$search}%")
                    ->orWhere('summaries.gst_amount', 'LIKE', "%{$search}%");
            });
        }

        // Get total records count
        $totalData = $query->count();

        // Apply pagination and sorting
        $invoices = $query->offset($start)
            ->limit($limit)
            ->orderBy($orderColumn, $dir)
            ->get();

        // Total filtered count
        $totalFiltered = $totalData; // Filtered count is the same as total count after search

        $data = [];
        $i = $start + 1;

        foreach ($invoices as $invoice) {
            $data[] = [
                'DT_RowIndex' => $i++,
                'company_name' => $invoice->company_name,
                'invoice_date' => \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y'),
                'invoice_no' => $invoice->invoice_no,
                'sum_no' => $invoice->sum_no . '/' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT),
                'performa_no' => $invoice->performa_no,
                'total' => $invoice->total,
                'gst_amount' => $invoice->gst_amount,
                'action' => '
                    <ul class="list-unstyled hstack gap-1 mb-0">
                        <li>
                            <a href="' . route('invoice.excel', $invoice->id) . '"
                            class="btn btn-sm btn-soft-primary">
                            <img src="' . asset('admin_assets/index_icon/xls.png') . '" alt="XLS" style="width: 15px;">
                            </a>
                        </li>
                        <li>
                            <a href="' . route('invoice.show', $invoice->id) . '"
                            target="_blank" class="btn btn-sm btn-soft-primary">
                            <i data-feather="file-text"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#completeInvoiceModal_' . $invoice->id . '">
                                <i data-feather="check"></i>
                            </a>

                            <div class="modal fade" id="completeInvoiceModal_' . $invoice->id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitle_' . $invoice->id . '" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitle_' . $invoice->id . '">Complete Invoice Details</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="' . route('complete.invoice') . '" method="POST" enctype="multipart/form-data">
                                                ' . csrf_field() . '
                                                <div class="row gx-3 mb-3">
                                                    <input type="hidden" name="invoice_no" value="' . $invoice->invoice_no . '">
                                                    <input type="hidden" name="invoice_id" value="' . $invoice->id . '" />
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="tds_' . $invoice->id . '">TDS</label>
                                                        <input class="form-control" id="tds_' . $invoice->id . '" type="text" name="tds" value="" />
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="retention_' . $invoice->id . '">Retention</label>
                                                        <input class="form-control" id="retention_' . $invoice->id . '" type="text" name="retention" value="" />
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="payment_receive_date_' . $invoice->id . '">Payment Receive Date</label>
                                                        <input class="form-control" id="payment_receive_date_' . $invoice->id . '" type="date" name="payment_receive_date" value="" />
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="payment_' . $invoice->id . '">Payment</label>
                                                        <input class="form-control" id="payment_' . $invoice->id . '" type="text" name="payment" value=""/>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="penalty_' . $invoice->id . '">Penalty</label>
                                                        <input class="form-control" id="penalty_' . $invoice->id . '" type="text" name="penalty" value=""/>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Add Complete Invoice</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#editInvoiceModal_' . $invoice->id . '">
                                <i data-feather="edit"></i>
                            </a>

                            <div class="modal fade" id="editInvoiceModal_' . $invoice->id . '" tabindex="-1" role="dialog" aria-labelledby="modalTitleEdit_' . $invoice->id . '" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleEdit_' . $invoice->id . '">Generate Invoice Details</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="' . route('invoice.update', $invoice->id) . '" method="POST">
                                                ' . csrf_field() . '
                                                ' . method_field('PUT') . '
                                                <div class="row gx-3 mb-3">
                                                    <div class="col-6 col-md-6">
                                                        <input type="hidden" name="company_id" value="' . $invoice->company_id . '">
                                                        <label class="small mb-1" for="invoice_date_' . $invoice->id . '">Invoice Date <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="invoice_date_' . $invoice->id . '" type="date" name="invoice_date" value="' . $invoice->invoice_date . '" />
                                                        <span id="error-invoice-date-message" class="error"></span>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="invoice_no_' . $invoice->id . '">Invoice No <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="invoice_no_' . $invoice->id . '" type="text" name="invoice_no" value="' . $invoice->invoice_no . '"

                                                                readonly
                                                             />
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Update Invoice</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                ',
            ];
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function Complete(Request $request)
    {
        if ($request->ajax()) {
            $Completeinvoice = CompleteInvoice::with('getSumarry.getCompany');

            return datatables()->of($Completeinvoice)
                ->addIndexColumn()
                ->editColumn('company_name', function($invoice) {
                    return $invoice->getSumarry->getCompany->companyname;
                })
                ->editColumn('invoice_no', function($invoice) {
                    return $invoice->getSumarry->invoice_no;
                })
                ->editColumn('invoice_date', function($invoice) {
                    return \Carbon\Carbon::parse($invoice->getSumarry->invoice_date)->format('d-m-Y');
                })
                ->editColumn('total', function($invoice) {
                    return $invoice->getSumarry->price_total;
                })
                ->addColumn('action', function($invoice) {
                    $modalId = 'exampleModalCenter' . $invoice->id;
                    $formId = 'completeInvoiceForm' . $invoice->id;

                    $editButton = '<a href="#" class="btn btn-sm btn-soft-primary" type="button" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i data-feather="check-square"></i></a>';

                    $modal = '
                        <div class="modal fade" id="' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Complete Invoice Details</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="' . $formId . '" method="POST">
                                            @csrf
                                            <input type="hidden" name="invoice_id" value="' . $invoice->id . '" />
                                            <div class="row gx-3 mb-3">
                                                <div class="col-6 col-md-6">
                                                    <label class="small mb-1" for="tds">TDS</label>
                                                    <input class="form-control" id="tds" type="text" name="tds" value="' . $invoice->tds . '" />
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="small mb-1" for="retention">Retention</label>
                                                    <input class="form-control" id="retention" type="text" name="retention" value="' . $invoice->retention . '" />
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="small mb-1" for="payment_receive_date">Payment Receive Date</label>
                                                    <input class="form-control" id="payment_receive_date" type="text" name="payment_receive_date" value="' . $invoice->payment_receive_date . '" />
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="small mb-1" for="payment">Payment</label>
                                                    <input class="form-control" type="text" name="payment" id="payment" value="' . $invoice->payment . '"/>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="small mb-1" for="penalty">Penalty</label>
                                                    <input class="form-control" type="text" name="penalty" id="penalty" value="' . $invoice->penalty . '"/>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Update Complete Invoice</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';


                    return $editButton . $modal;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.accountant.invoice.complete');
    }

    public function performaInvoiceReport()
    {
        $companies = RegisterCompany::get();
        return view('admin.accountant.invoice.performa_invoice_report',compact('companies'));
    }

    public function getInvoiceByDateAndCompany(Request $request)
    {
        $company = $request->input('company_id');
        $purchaseOrder = $request->input('po_no_id');
        $workContractOrderNo = $request->input('work_contract_order_no');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Invoice::select('register_companies.companyname', 'purchase_orders.po_no','invoices.*')
            ->join('register_companies', 'invoices.company_id', '=', 'register_companies.id')
            ->leftJoin('purchase_orders', 'invoices.po_no_id', '=', 'purchase_orders.id')
            ->where('invoices.company_id', $company)
            ->where('invoices.status', $status)
            ->whereBetween('invoices.created_at', [$startDate, $endDate])
            ->when($purchaseOrder, function($query, $purchaseOrder) {
                return $query->where('invoices.po_no_id', $purchaseOrder);
            })
            ->when($workContractOrderNo, function($query, $workContractOrderNo) {
                return $query->where('invoices.work_contract_order_no', $workContractOrderNo);
            })
            ->groupBy(
                'register_companies.companyname',
                'purchase_orders.po_no',
                'invoices.id',
                'invoices.company_id',
                'invoices.status',
                'invoices.created_at',
                'invoices.updated_at',
                'invoices.po_no_id',
                'invoices.unit',
                'invoices.jmr_no',
                'invoices.work_contract_order_no',
                'invoices.plant',
                'invoices.department',
                'invoices.category_of_service_id',
                'invoices.invoice_no',
                'invoices.performa_no',
                'invoices.invoice_date',
                'invoices.performa_date',
                'invoices.tax',
                'invoices.work_period',
                'invoices.total',
                'invoices.gst_amount'
            )
            ->get();

        return response()->json($query);
    }

    public function getInvoicePerformaByDateAndCompany(Request $request)
    {
        $company = $request->input('company_id');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $invoices = Summary::select([
            'register_companies.companyname',
            'category_of_services.category_of_service',
            'purchase_orders.po_no',
            'purchase_orders.po_date',
        ])
        ->join('register_companies', 'summaries.company_id', '=', 'register_companies.id')
        ->join('category_of_services', 'summaries.category_of_service_id', '=', 'category_of_services.id')
        ->leftJoin('purchase_orders', 'summaries.po_no_id', '=', 'purchase_orders.id')  // Use leftJoin
        ->where('summaries.company_id', $company)
        ->where('summaries.status', $status)
        ->whereBetween('summaries.created_at', [$startDate, $endDate])
        ->groupBy(
            'register_companies.companyname',
            'category_of_services.category_of_service',
            'purchase_orders.po_no',
            'purchase_orders.po_date',
            'summaries.id',
            'summaries.company_id',
            'summaries.status',
            'summaries.created_at',
            'summaries.updated_at',
            'summaries.po_no_id',
            'summaries.unit',
            'summaries.jmr_no',
            'summaries.work_contract_order_no',
            'summaries.plant',
            'summaries.department',
            'summaries.category_of_service_id',
            'summaries.invoice_no',
            'summaries.performa_no',
            'summaries.invoice_date',
            'summaries.performa_date',
            'summaries.tax',
            'summaries.work_period',
            'summaries.total',
            'summaries.gst_amount'
        )
        ->get();


        return response()->json(['data' => $invoices]);



    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Summary::find($id);
        $products = SummaryProduct::where('summary_id', $id)
        ->select('summary_products.price', 'summary_products.job_description', 'summary_products.service_code_id')
        ->selectRaw('SUM(summary_products.total_qty) as total_qty')
        ->join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id') // Adjust the table and column names as necessary
        ->groupBy('summary_products.service_code_id', 'summary_products.job_description', 'summary_products.price')
        ->distinct()
        ->orderBy('company_service_codes.service_code') // Order by service_code
        ->get();
        $purchaseOrder = SummaryProduct::where('summary_id',$id)->with('purchaseOrder')->first();

        // $purchaseOrder = InvoiceProduct::where('invoice_id',$id)->with('purchaseOrder')->first();
        $i = 1;
        $sub_total = 0;
        $word = $this->numberToWord($invoice->gst_amount);

        $data = compact('invoice','products','i','sub_total','word','purchaseOrder');

        $pdf = PDF::loadView('admin.accountant.invoice.show',$data);
        return $pdf->stream($invoice->invoice_no .'/00'. $invoice->id.'.pdf');

        return view('admin.accountant.invoice.show',$data);
    }

    public function exportExcel($id)
    {
        $invoice = Summary::find($id);

        $products = SummaryProduct::where('summary_id', $id)
            ->select(
                'summary_products.price',
                'summary_products.job_description',
                'summary_products.service_code_id',
                'company_service_codes.service_code'
            )
            ->selectRaw('SUM(summary_products.total_qty) as total_qty')
            ->join('company_service_codes', 'summary_products.service_code_id', '=', 'company_service_codes.id')
            ->groupBy(
                'summary_products.service_code_id',
                'summary_products.job_description',
                'summary_products.price',
                'company_service_codes.service_code' // Add this to groupBy
            )
            ->distinct()
            ->orderBy('company_service_codes.service_code') // Order by service_code
            ->get();

        $purchaseOrder = SummaryProduct::where('summary_id', $id)->with('purchaseOrder')->first();

        // $purchaseOrder = InvoiceProduct::where('invoice_id',$id)->with('purchaseOrder')->first();
        $i = 1;
        $sub_total = 0;
        $word = $this->numberToWord($invoice->gst_amount);

        $data = compact('invoice','products','i','sub_total','word','purchaseOrder');

        $filename = $invoice->invoice_no .'.xlsx';
        $filename = str_replace(['/', '\\'], '_', $filename); // Replace '/' and '\' with '_'

        return Excel::download(new InvoiceExport($data), $filename);
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


    public function completeInvoice(Request $request)
    {

        $existingInvoice = CompleteInvoice::where('invoice_id', $request->invoice_id)->first();

        if ($existingInvoice) {
            return redirect()->back()->with('error', 'This invoice has already been completed.');
        }

        $validatedData = $request->validate([
            'invoice_id' => 'required',
            'tds' => 'required',
            'retention' => 'required',
            'payment_receive_date' => 'required',
            'payment' => 'required',
            'penalty' => 'required',

        ]);

        // Create a new complete invoice entry
        $completeInvoice = new CompleteInvoice();
        $completeInvoice->invoice_id = $validatedData['invoice_id'];
        $completeInvoice->tds = $validatedData['tds'];
        $completeInvoice->retention = $validatedData['retention'];
        $completeInvoice->payment_receive_date = $validatedData['payment_receive_date'];
        $completeInvoice->payment = $validatedData['payment'];
        $completeInvoice->penalty = $validatedData['penalty'];

        $completeInvoice->save();

        // Update status of invoice in invoices table
        $invoice = Summary::where('id', $validatedData['invoice_id'])->first();
        if ($invoice) {
            $invoice->invoice_status = 'Complete';
            $invoice->save();
        }

        return redirect()->back()->with('success', 'Invoice details completed successfully.');
    }

    public function getCompleteInvoice($id)
    {
        $Completeinvoice = CompleteInvoice::find($id);

        if ($Completeinvoice) {
            return response()->json($Completeinvoice);
        } else {
            return response()->json(['message' => 'Complete Invoice not found'], 404);
        }
    }

    public function updateCompleteInvoice(Request $request)
    {
        $Completeinvoice = CompleteInvoice::find($request->invoice_id); // Notice the change here

        if ($Completeinvoice) {
            $Completeinvoice->tds = $request->tds;
            $Completeinvoice->retention = $request->retention;
            $Completeinvoice->payment_receive_date = $request->payment_receive_date;
            $Completeinvoice->payment = $request->payment;
            $Completeinvoice->penalty = $request->penalty;
            $Completeinvoice->save();

            return response()->json(['success' => 'Complete Invoice updated successfully', 'Completeinvoice' => $Completeinvoice]);
        } else {
            return response()->json(['danger' => 'Complete Invoice not found'], 404);
        }
    }

    public function deleteCompleteInvoice($id)
    {
        // Find the CompleteInvoice by ID
        $completeInvoice = CompleteInvoice::find($id);

        // Check if the CompleteInvoice exists
        if (!$completeInvoice) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        // Get the related invoice_id from CompleteInvoice
        $invoiceId = $completeInvoice->invoice_id;

        // Delete the CompleteInvoice
        $completeInvoice->delete();

        // Find the related Summary by invoice_id and update its status
        $summary = Summary::find($invoiceId);

        if ($summary) {
            // Update the invoice status to 'Pending'
            $summary->invoice_status = 'Pending';
            $summary->save();
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Invoice Deleted Successfully.');
    }

    /**
     * Update the specified resource in storage.
     */


    // public function update(Request $request, $id)
    // {
    //     $invoice = Summary::findOrFail($id);

    //     $companyId = $request->input('company_id');
    //     $company = RegisterCompany::findOrFail($companyId);

    //     if (empty($invoice->invoice_no)) {
    //         // Generate invoice number only if it's null
    //         $lastInvoice = Summary::where('invoice_no', 'like', "%/INV/%")
    //             ->orderByRaw('RIGHT(invoice_no, 4) DESC')
    //             ->first();

    //         $lastNumber = 0;
    //         if ($lastInvoice && preg_match('/(\d{4})$/', $lastInvoice->invoice_no, $matches)) {
    //             $lastNumber = intval($matches[0]);
    //         }

    //         $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

    //         $currentYear = date('y');
    //         $startYear = ($currentYear - 1) . '-' . $currentYear;
    //         if (date('n') >= 4) { // April onwards
    //             $startYear = $currentYear . '-' . ($currentYear + 1);
    //         }

    //         $invoiceNo = "{$startYear}/INV/{$company->inv_no_name}/{$nextNumber}";

    //         ActivityLog::create([
    //             'user_id' => Auth::id(),
    //             'action' => 'Auto-generated',
    //             'entity_type' => 'Invoice No',
    //             'entity_id' => $invoice->id,
    //             'details' => "Invoice Auto-generated with {$invoiceNo}",
    //         ]);
    //     } else {
    //         $invoiceNo = $request->input('invoice_no');

    //         // **Check for uniqueness before updating**
    //         $exists = Summary::whereRaw("RIGHT(invoice_no, 4) = ?", [substr($invoiceNo, -4)])
    //             ->where('id', '!=', $id) // Exclude current invoice
    //             ->exists();

    //         if ($exists) {
    //             return back()->with('error', 'Invoice number already exists.');
    //         }

    //         ActivityLog::create([
    //             'user_id' => Auth::id(),
    //             'action' => 'Manually-generated',
    //             'entity_type' => 'Invoice No',
    //             'entity_id' => $invoice->id,
    //             'details' => "Invoice Manually-generated with {$invoiceNo}",
    //         ]);
    //     }

    //     $invoice->update([
    //         'invoice_date' => $request->invoice_date,
    //         'invoice_no' => $invoiceNo,
    //         'performa_status' => 'Complete',
    //     ]);

    //     return back()->with('success', 'Invoice Updated Successfully');
    // }

    public function update(Request $request, $id)
{
    $invoice = Summary::findOrFail($id);

    // If invoice status is 'Cancel', change it to 'Pending'
    if ($invoice->invoice_status === 'Cancel') {
        $invoice->invoice_status = 'Pending';
    }

    $companyId = $request->input('company_id');
    $company = RegisterCompany::findOrFail($companyId);

    if (empty($invoice->invoice_no)) {
        // Generate invoice number only if it's null
        $lastInvoice = Summary::where('invoice_no', 'like', "%/INV/%")
            ->orderByRaw('RIGHT(invoice_no, 4) DESC')
            ->first();

        $lastNumber = 0;
        if ($lastInvoice && preg_match('/(\d{4})$/', $lastInvoice->invoice_no, $matches)) {
            $lastNumber = intval($matches[0]);
        }

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $currentYear = date('y');
        $startYear = ($currentYear - 1) . '-' . $currentYear;
        if (date('n') >= 4) { // April onwards
            $startYear = $currentYear . '-' . ($currentYear + 1);
        }

        $invoiceNo = "{$startYear}/INV/{$nextNumber}";

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Auto-generated',
            'entity_type' => 'Invoice No',
            'entity_id' => $invoice->id,
            'details' => "Invoice Auto-generated with {$invoiceNo}",
        ]);
    } else {
        $invoiceNo = $request->input('invoice_no');

        // **Check for uniqueness before updating**
        $exists = Summary::whereRaw("RIGHT(invoice_no, 4) = ?", [substr($invoiceNo, -4)])
            ->where('id', '!=', $id) // Exclude current invoice
            ->exists();

        if ($exists) {
            return back()->with('error', 'Invoice number already exists.');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Manually-generated',
            'entity_type' => 'Invoice No',
            'entity_id' => $invoice->id,
            'details' => "Invoice Manually-generated with {$invoiceNo}",
        ]);
    }

    $invoice->update([
        'invoice_date' => $request->invoice_date,
        'invoice_no' => $invoiceNo,
        'performa_status' => 'Complete',
        'invoice_status' => $invoice->invoice_status, // Ensure status update if needed
    ]);

    return back()->with('success', 'Invoice Updated Successfully');
}



    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $invoice = Summary::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted',
            'entity_type' => 'Invoice No',
            'entity_id' => $invoice->id,
            'details' => 'Invoice deleted with ' . $invoice->invoice_no
        ]);

        $invoice->invoice_no = null;
        $invoice->invoice_date = null;

        $invoice->save();

        return redirect()->back()->with('success', 'Invoice Deleted Successfully.');
    }


    public function cancel($invoiceId)
    {
        $invoice = Summary::findOrFail($invoiceId);

        $oldStatus = $invoice->invoice_status;
        $newStatus = 'Cancel';

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Status Changed',
            'entity_type' => 'Invoice/Performa Status',
            'entity_id' => $invoice->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'details' => "Invoice/Performa status changed from $oldStatus to $newStatus"
        ]);

        $invoice->invoice_status = $newStatus;
        $invoice->performa_status = $newStatus;

        $invoice->save();

        return redirect()->back()->with('success', 'Invoice canceled successfully.');
    }

    // public function checkUniqueInvoice(Request $request)
    // {
    //     $exists = DB::table('summaries')
    //         ->whereRaw("RIGHT(invoice_no, 4) = ?", [$request->lastFourDigits])
    //         ->exists();

    //     return response()->json(['exists' => $exists]);
    // }



}
