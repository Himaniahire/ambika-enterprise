<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Summary;
use App\Models\PurchaseOrder;
use App\Models\CompleteInvoice;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
{
    $invoice = Summary::whereNotNull('invoice_no')->count();
    $performa = Summary::whereNotNull('performa_no')->count();
    $po = PurchaseOrder::count();
    $CompleteInvoice = CompleteInvoice::count();

    return view('admin.index', compact('invoice', 'performa', 'po', 'CompleteInvoice'));
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
