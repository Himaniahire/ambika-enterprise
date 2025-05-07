<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summary;
use App\Models\SummaryProduct;
use App\Models\RegisterCompany;
use App\Models\CompanyServiceCode;
use App\Models\CompleteInvoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SummaryExport;
use DB;

class AccountantController extends Controller
{
    public function index()
    {
        return view('admin.accountant.index');
    }

    /**
     * Report fuction Fecth the data summary data
     */
    public function companyPoReport()
    {
        $companies = RegisterCompany::get();
        $purchaseOrder = PurchaseOrder::get();
        $performas = Summary::get();
        return view('admin.accountant.reports.company_po_report',compact('companies','purchaseOrder','performas'));
    }

    public function masterReport()
    {
        $companies = RegisterCompany::get();
        return view('admin.accountant.reports.master_report',compact('companies'));
    }

    public function companyInvReport()
    {
        $companies = RegisterCompany::get();
        $purchaseOrder = PurchaseOrder::get();
        $performas = Summary::get();
        return view('admin.accountant.reports.company_inv_report',compact('companies','purchaseOrder','performas'));
    }

    public function invoiveReport()
    {
        $companies = RegisterCompany::get();
        $purchaseOrder = PurchaseOrder::get();
        $performas = Summary::get();
        return view('admin.accountant.reports.invoice_report',compact('companies','purchaseOrder','performas'));
    }

    public function finalInvoiceReport()
    {
        $companies = RegisterCompany::get();
        $purchaseOrder = PurchaseOrder::get();
        $performas = Summary::get();
        return view('admin.accountant.reports.final_invoice_report',compact('companies','purchaseOrder','performas'));
    }

    public function serviceCodeReport()
    {
        $companies = RegisterCompany::get();
        $purchaseOrder = PurchaseOrder::get();
        $performas = Summary::get();
        return view('admin.accountant.reports.service_code_report',compact('companies','purchaseOrder','performas'));
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


    public function fetchDataCompany(Request $request)
    {
        $companyId = $request->input('company_id');
        $poId = $request->input('po_id');
        $serviceCodeId = $request->input('service_code_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');

        $query = Summary::whereNotNull(['invoice_no','performa_no'])
            ->with(['getCompany', 'summaryProducts.companyServiceCode', 'getPO']);

        $query->where(function ($q) {
            $q->where('invoice_status', '!=', 'Cancel')
            ->orWhereNull('invoice_status');
        })
        ->where(function ($q) {
            $q->where('performa_status', '!=', 'Cancel')
            ->orWhereNull('performa_status');
        });

        if (!empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        if ($poId) {
            $query->whereHas('summaryProducts', function ($q) use ($poId) {
                $q->where('po_id', $poId);
            });
        }

        if ($serviceCodeId) {
            $query->whereHas('summaryProducts', function ($q) use ($serviceCodeId) {
                $q->where('service_code_id', $serviceCodeId);
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('invoice_date', [$startDate, $endDate]);
        }

        if ($month) {
            $yearMonth = \Carbon\Carbon::parse($month);
            $query->whereYear('invoice_date', $yearMonth->year)
                  ->whereMonth('invoice_date', $yearMonth->month);
        }




        $summaries = $query->orderByRaw("RIGHT(invoice_no, 4) ASC")->get();

        $dynamicTitle = '';
        if ($month) {
            $yearMonth = \Carbon\Carbon::parse($month);
            $monthName = strtoupper($yearMonth->format('F'));
            $yearStart = $yearMonth->format('y');
            $yearEnd = ($yearStart + 1) % 100;
        } elseif ($startDate && $endDate) {
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);

            $monthName = strtoupper($start->format('F')) . "_TO_" . strtoupper($end->format('F'));
            $yearStart = $start->format('y');
            $yearEnd = ($end->format('y') + 1) % 100;
        } else {
            $monthName = 'UNKNOWN';
            $yearStart = 'XX';
            $yearEnd = 'XX';
        }

        $firstInvoiceDigits = $summaries->isNotEmpty() ? substr($summaries->first()->invoice_no, -4) : '0001';
        $lastInvoiceDigits = $summaries->isNotEmpty() ? substr($summaries->last()->invoice_no, -4) : '0100';

        $dynamicTitle = "{$yearStart}-{$yearEnd}_{$monthName}_AMBIKA_({$firstInvoiceDigits}_TO_{$lastInvoiceDigits})";


        $totalPrice = $summaries->sum('price_total');

        $summaries->transform(function ($summary) use ($poId, $serviceCodeId) {
            $data = [
                'id' => $summary->id,
                'companyname' => $summary->getCompany->companyname,
                'sum_no' => $summary->sum_no,
                'invoice_date' => \Carbon\Carbon::parse($summary->invoice_date)->format('d-m-Y'),
                'invoice_no' => $summary->invoice_no,
                'po_no' => $summary->getPO ? $summary->getPO->po_no : 'N/A',
                'price_total' => $summary->price_total,
                'gst_amount' => $summary->gst_amount,
            ];

            if ($serviceCodeId) {
                foreach ($summary->summaryProducts as $summaryProduct) {
                    if ($summaryProduct->service_code_id == $serviceCodeId) {
                        $data['service_code'] = $summaryProduct->companyServiceCode->service_code;
                    }
                }
            } else {
                $data['total'] = $summary->total;
            }

            return $data;
        });

        $service_code = null;
        if ($serviceCodeId) {
            $service_code = DB::table('company_service_codes')
                ->where('id', $serviceCodeId)
                ->value('service_code');
        }

        return response()->json([
            'summaries' => $summaries,
            'total_price' => $totalPrice,
            'service_code' => $service_code,
            'dynamic_title' => $dynamicTitle,
        ]);
    }

    public function fetchDataInvoice(Request $request)
    {
        $company_id = $request->company_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $month = $request->month;
    
        $query = DB::table('summaries')
            ->leftJoin('complete_invoices', 'summaries.id', '=', 'complete_invoices.invoice_id')
            ->leftJoin('register_companies', 'summaries.company_id', '=', 'register_companies.id')
            ->whereNotNull('summaries.invoice_no') // Exclude records where invoice_no is NULL
            ->where('summaries.invoice_status', 'Complete');
    
        // Filter by date range if both start and end dates are provided
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('summaries.invoice_date', [$start_date, $end_date]);
        }
    
        // Filter by company_id if provided
        if (!empty($company_id)) {
            $query->where('summaries.company_id', $company_id);
        }
    
        // Filter by month if provided
        if ($month) {
            $yearMonth = \Carbon\Carbon::parse($month);
            $query->whereYear('invoice_date', $yearMonth->year)
                  ->whereMonth('invoice_date', $yearMonth->month);
        }
    
        // Select the required columns
        $query->selectRaw("
            summaries.invoice_no,
            DATE_FORMAT(summaries.invoice_date, '%d-%m-%Y') as formatted_invoice_date,
            DATE_FORMAT(complete_invoices.payment_receive_date, '%d-%m-%Y') as formatted_payment_receive_date,
            summaries.invoice_status,
            summaries.price_total,
            summaries.gst_amount,
            complete_invoices.penalty,
            complete_invoices.payment,
            complete_invoices.tds,
            complete_invoices.retention,
            register_companies.companyname
        ")
        ->orderByRaw("CAST(SUBSTRING_INDEX(summaries.invoice_no, '/', -1) AS UNSIGNED) ASC");
    
        // Fetch results
        $result = $query->get();
    
        return response()->json([
            'data' => $result,
            'recordsTotal' => $result->count(),
            'recordsFiltered' => $result->count(),
        ]);
    }

    
    public function fetchDataCompanyInvoice(Request $request)
    {
        $companyId = $request->input('company_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $month = $request->input('month');
        $status = $request->input('status');
    
        $summariesQuery = Summary::query()
            ->select('id', 'company_id', 'sum_no', 'invoice_no', 'performa_no', 'po_no_id', 'price_total', 'gst_amount', 'performa_date', 'invoice_date', 'performa_status')
            ->with('getCompany', 'getPO');
    
        // Removed invoice_status filter completely
    
        // Filter by date range
        if ($startDate && $endDate) {
            $summariesQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        // Filter by month
        if (!empty($month)) {
            $summariesQuery->whereMonth('created_at', '=', \Carbon\Carbon::parse($month)->month)
                           ->whereYear('created_at', '=', \Carbon\Carbon::parse($month)->year);
        }
    
        // Filter by company
        if ($companyId !== null && $companyId != 0) {
            $summariesQuery->where('company_id', $companyId);
        }
    
        // Filter by performa status if provided and not "All"
        if (!empty($status) && $status !== 'All') {
            $summariesQuery->where('performa_status', $status);
        } else {
            $summariesQuery->where('invoice_status', '!=', 'Cancel')
                           ->where('performa_status', '!=', 'Cancel');
        }
    
    
        // Order by numeric part of performa_no
        $summariesQuery->orderByRaw("CAST(SUBSTRING_INDEX(summaries.performa_no, '/', -1) AS UNSIGNED) ASC");
    
        $summaries = $summariesQuery->get();
    
        // Transform data
        $summaries->transform(function ($summary) {
            return [
                'companyname' => $summary->getCompany->companyname ?? 'N/A',
                'sum_no' => $summary->sum_no,
                'performa_date' => $summary->performa_date,
                'price_total' => $summary->price_total,
                'gst_amount' => $summary->gst_amount,
                'invoice_date' => $summary->invoice_date ? \Carbon\Carbon::parse($summary->invoice_date)->format('d-m-Y') : 'N/A',
                'performa_no' => $summary->performa_no,
                'po_no' => $summary->getPO->po_no ?? 'N/A',
                'total' => $summary->getPO->total ?? 'N/A',
                'performa_status' => $summary->performa_status,
            ];
        });
    
        return response()->json([
            'summaries' => $summaries,
        ]);
    }


    public function generateExcel(Request $request)
    {
        $companyId = $request->company_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $month = $request->month;

        if ($companyId) {
            $company = RegisterCompany::find($companyId);
        } else {
            $company = RegisterCompany::get();
        }
        $comany_id = [];
        $companyName = [];
        $gstNumber = [];
        $panNumber = [];
        $state = [];

        // If a single company is selected
        if ($companyId && $company) {
            $comany_id[] = $company->id;
            $companyName[] = $company->companyname;
            $gstNumber[] = $company->gstnumber;
            $panNumber[] = $company->pannumber;
            $state[] = $company->state;
        } elseif ($company) {
            // Multiple companies
                foreach ($company as $comp) {
                    $comany_id[] = $comp->id;
                    $companyName[] = $comp->companyname;
                    $gstNumber[] = $comp->gstnumber;
                    $panNumber[] = $comp->pannumber;
                    $state[] = $comp->state;
            }
        }


        // Query the summaries table based on company_id, date range, and month
        $query = Summary::query();

        if ($companyId) {
            $query->where('company_id', $companyId);

        }

        if ($startDate) {
            $query->whereDate('invoice_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('invoice_date', '<=', $endDate);
        }

        if ($month) {
            $query->whereMonth('invoice_date', '=', date('m', strtotime($month)));
        }
        $summaries = $query->with(relations: ['getPO', 'summaryProduct','companyServiceCode','getCompany'])->get();

        $filename = 'summaries.xlsx';

        if ($startDate && $endDate) {
            $filename = 'summaries_' . date('d-m-Y', strtotime($startDate)) . '_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        } elseif ($month) {
            $filename = 'summaries_' . strtoupper(date('F_Y', strtotime($month))) . '.xlsx';
        }

        return Excel::download(new SummaryExport($summaries, $companyName, $gstNumber, $panNumber, $state,$comany_id), $filename);
    }






}

