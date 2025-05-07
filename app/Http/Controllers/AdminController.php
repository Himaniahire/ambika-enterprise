<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Summary;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegisterCompany;
use App\Exports\TableExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $invoice = Summary::whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')->count();
        $performa = Summary::whereNotNull('performa_no')->where('performa_status', '!=', 'Cancel')->count();
        $po = PurchaseOrder::count();
        $Pendingperforma = Summary::whereNull('invoice_no')->where('invoice_status', '!=', 'Cancel')->where('performa_status', '!=', 'Cancel')->count();
        $companies = RegisterCompany::whereHas('summaries', function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel');
        })->with(['summaries' => function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel')
                  ->select('company_id', 'price_total', 'gst_amount', 'invoice_no', 'performa_no');
        }])->get();


        $data = [];

        foreach ($companies as $index => $company) {
            $totalWithTax = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');
            $totalWithoutTax = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            $pendingWithTax = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');
            $pendingWithoutTax = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            $data[] = [
                'sr_no' => $index + 1,
                'company_name' => $company->companyname,
                'total_with_tax' => number_format($totalWithTax, 2),
                'total_without_tax' => number_format($totalWithoutTax, 2),
                'pending_with_tax' => number_format($pendingWithTax, 2),
                'pending_without_tax' => number_format($pendingWithoutTax, 2),
            ];
        }

        // return response()->json(['data' => $data]);

        return view('admin.index', compact('invoice', 'performa', 'po', 'Pendingperforma','data'));
    }
    public function exportExcel()
    {
        return Excel::download(new TableExport, 'company_summary.xlsx');
    }

    public function exportPDF()
    {
        $companies = RegisterCompany::whereHas('summaries', function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel');
        })->with(['summaries' => function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel')
                  ->select('company_id', 'price_total', 'gst_amount', 'invoice_no', 'performa_no');
        }])->get();


        $data = [];

        foreach ($companies as $index => $company) {
            $totalWithTax = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');
            $totalWithoutTax = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            $pendingWithTax = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');
            $pendingWithoutTax = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            $data[] = [
                'sr_no' => $index + 1,
                'company_name' => $company->companyname,
                'total_with_tax' => number_format($totalWithTax, 2),
                'total_without_tax' => number_format($totalWithoutTax, 2),
                'pending_with_tax' => number_format($pendingWithTax, 2),
                'pending_without_tax' => number_format($pendingWithoutTax, 2),
            ];
        }

        // 👇 Make sure to pass as ['data' => $data] matching the view
        $pdf = PDF::loadView('admin.table', ['data' => $data]);
        return $pdf->download('company_summaries.pdf');
    }


    public function getChartData()
    {
        // Month names for labels
        $monthNames = [
            1 => "Jan", 2 => "Feb", 3 => "March", 4 => "April",
            5 => "May", 6 => "June", 7 => "July", 8 => "Aug",
            9 => "Sept", 10 => "Oct", 11 => "Nov", 12 => "Dec"
        ];
        
        $currentYear = Carbon::now()->year;

        $data = DB::table('summaries')
            ->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')
            ->select(
                DB::raw('MONTH(performa_date) as month'),
                DB::raw('SUM(gst_amount) as total_gst')
            )
            ->groupBy(DB::raw('MONTH(performa_date)'))
            ->get()
            ->keyBy('month');

        
        // Invoice data
        $dataInv = DB::table('summaries')
            ->whereNotNull('invoice_date')
            ->whereYear('invoice_date', $currentYear)
            ->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')
            ->select(
                DB::raw('MONTH(invoice_date) as month'),
                DB::raw('SUM(gst_amount) as total_gst')
            )
            ->groupBy(DB::raw('MONTH(invoice_date)'))
            ->get()
            ->keyBy('month');
            
        $dataPendPerforma = DB::table('summaries')
            ->whereNull('invoice_no')
            ->whereYear('performa_date', $currentYear)
            ->where('invoice_status', '!=', 'Cancel')
            ->where('performa_status', '!=', 'Cancel')
            ->selectRaw('MONTH(performa_date) as month, SUM(gst_amount) as total_gst, COUNT(*) as total_count')
            ->groupByRaw('MONTH(performa_date)')
            ->get()
            ->keyBy('month');


        // Max GST value
        $max = DB::table('summaries')
            ->select(DB::raw('MAX(gst_amount) as max_gst_amount'))
            ->first();
        $maxGstAmount = $max->max_gst_amount;

        // Build final data for all 12 months
        $labels = [];
        $gstperValues = [];
        $gstinvValues = [];
        $gstpenperValues = [];

        foreach ($monthNames as $monthNum => $monthLabel) {
            $labels[] = $monthLabel;
            $gstperValues[] = isset($data[$monthNum]) ? $data[$monthNum]->total_gst : 0;
            $gstinvValues[] = isset($dataInv[$monthNum]) ? $dataInv[$monthNum]->total_gst : 0;
            $gstpenperValues[] = isset($dataPendPerforma[$monthNum]) ? $dataPendPerforma[$monthNum]->total_gst : 0;
        }

        return response()->json([
            'labels' => $labels,
            'maxGstAmount' => $maxGstAmount,
            'datasets' => [
                [
                    'label' => 'Performa',
                    'backgroundColor' => '#6900c7',
                    'hoverBackgroundColor' => '#6900c7',
                    'borderColor' => '#4e73df',
                    'data' => $gstperValues,
                    'maxBarThickness' => 25,
                ],
                [
                    'label' => 'Invoice',
                    'backgroundColor' => '#00ac69',
                    'hoverBackgroundColor' => '#00ac69',
                    'borderColor' => '#1cc88a',
                    'data' => $gstinvValues,
                    'maxBarThickness' => 25,
                ],
                [
                    'label' => 'Pending Performa',
                    'backgroundColor' => '#00cfd5',
                    'hoverBackgroundColor' => '#00cfd5',
                    'borderColor' => '#1cc88a',
                    'data' => $gstpenperValues,
                    'maxBarThickness' => 25,
                ],
            ]
        ]);
    }


    public function activityLog(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'full_name', // Alias for concatenated name
                1 => 'activity_logs.action',
                2 => 'activity_logs.entity_type', // Fixed column name
                3 => 'activity_logs.entity_id',
                4 => 'activity_logs.details',
                5 => 'activity_logs.created_at',
            ];

            // Base query with join and name concatenation
            $query = ActivityLog::join('users', 'users.id', '=', 'activity_logs.user_id')
                ->select([
                    DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) AS full_name"), // Fix NULL issue
                    'activity_logs.action',
                    'activity_logs.entity_type',
                    'activity_logs.entity_id',
                    'activity_logs.details',
                    'activity_logs.created_at',
                ]);

            // Search Filter
            if ($request->has('search') && !empty($request->input('search.value'))) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where(DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), 'like', "%{$searchValue}%")
                      ->orWhere('activity_logs.action', 'like', "%{$searchValue}%")
                      ->orWhere('activity_logs.entity_type', 'like', "%{$searchValue}%")
                      ->orWhere('activity_logs.entity_id', 'like', "%{$searchValue}%")
                      ->orWhere('activity_logs.details', 'like', "%{$searchValue}%")
                      ->orWhere('activity_logs.created_at', 'like', "%{$searchValue}%");
                });
            }

            // Sorting
            if ($request->has('order')) {
                $orderColumn = $columns[$request->input('order.0.column')];
                $orderDirection = $request->input('order.0.dir');
                $query->orderBy($orderColumn, $orderDirection);
            }

            // Always order by created_at DESC
            $query->orderBy('activity_logs.created_at', 'DESC');

            // Pagination
            $limit = $request->input('length', 10); // Default limit is 10
            $offset = $request->input('start', 0);

            // Fetch filtered records with pagination
            $filteredRecords = $query->count();
            $logs = $query->offset($offset)->limit($limit)->get();

            // Total records count (before filtering)
            $totalRecords = ActivityLog::count();

            // Format data manually
            $data = [];
            foreach ($logs as $log) {
                $data[] = [
                    'full_name' => $log->full_name,
                    'action' => $log->action,
                    'entity' => $log->entity_type,
                    'entity_id' => $log->entity_id,
                    'details' => $log->details,
                    'created_at' => $log->created_at ? $log->created_at->format('d-M-Y h:i A') : '',
                ];
            }

            // Return JSON response for DataTable
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }

        return view('admin.activity_log.index');
    }
}
