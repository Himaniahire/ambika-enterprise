<?php

namespace App\Http\Controllers;

use App\Models\RegisterCompany;
use App\Models\SummaryProduct;
use App\Models\Summary;
use App\Models\CompanyServiceCode;
use Yajra\DataTables\DataTables;
use App\Models\GstNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class RegisterCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies = RegisterCompany::select(['id', 'companyname', 'phone', 'email', 'gstnumber', 'pannumber', 'state', 'created_at', 'com_status']);

            return DataTables::of($companies)
                ->addIndexColumn()
                ->editColumn('phone', function($row){
                    return '<p class="mb-1">' . $row->phone . '</p><p class="mb-0">' . $row->email . '</p>';
                })
                ->editColumn('created_at', function($row){
                    return $row->created_at->format('d-m-Y');
                })
                ->addColumn('status', function($row){
                    $btnClass = $row->com_status ? 'btn-switch-on' : 'btn-switch-off';
                    $icon = $row->com_status ? 'toggle-right' : 'toggle-left';
                
                    return '<button class="toggle-status btnn ' . $btnClass . '" data-id="' . $row->id . '" data-status="' . ($row->com_status ? 1 : 0) . '" style="background: none; border: none;">
                                <i data-feather="' . $icon . '" style="width: 50px;"></i>
                            </button>';
                })
                
                ->addColumn('action', function($row){
                    return '<ul class="list-unstyled hstack gap-1 mb-0"><li><a class="btn btn-sm btn-soft-danger" href="' . route('register_company.edit', $row->id) . '"><i data-feather="edit"></i></a></li></ul>';
                })
                ->rawColumns(['phone', 'status', 'action'])
                ->make(true);
        }

        return view('admin.accountant.register_company.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accountant.register_company.add');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'companyname' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'email' => 'nullable|email|unique:register_companies,email',
            'phone' => 'nullable|numeric|digits:10',
            'inv_no_name' => 'required|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'required|string|max:255',
            'gstnumber' => 'required|array|min:1',
            'gstnumber.*' => 'required|string|max:255',
            'pannumber' => 'required',
            'order_no.*' => 'required',
            'service_code.*' => 'required|string|unique:company_service_codes,service_code',
            'job_description.*' => 'required|string',
            'uom.*' => 'required|string',
            'price.*' => 'required|numeric',
        ]);

        // Store company details
        $companies = new RegisterCompany([
            "companyname" => $request->companyname,
            "state" => $request->state,
            "inv_no_name" => $request->inv_no_name,
            "vendor_code" => $request->vendor_code,
            "email" => $request->email,
            "phone" => $request->phone,
            "address_1" => $request->address_1,
            "address_2" => $request->address_2,
            "address_3" => $request->address_3,
            "gstnumber" => $request->gstnumber[0],
            "pannumber" => $request->pannumber,
            "is_lut" => $request->is_lut,
            "lut_no" => $request->lut_no,
            "doa" => $request->doa,
        ]);
        $companies->save();

        // Store each GST number into the gst_number table
        foreach ($request->gstnumber as $gstnumber) {
            GstNumber::create([
                'company_id' => $companies->id,
                'gstnumber' => $gstnumber,
            ]);
        }

        // Store company services
        $companies_id = $companies->id;
        foreach($request->job_description as $key => $descriptions)
        {
            $companiesService['job_description']  = $descriptions;
            $companiesService['company_id']       = $companies_id;
            $companiesService['order_no']         = $request->order_no[$key];
            $companiesService['service_code']     = $request->service_code[$key];
            $companiesService['uom']              = $request->uom[$key];
            $companiesService['price']            = $request->price[$key];
            CompanyServiceCode::create($companiesService);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Company Added',
            'entity_type' => 'New Company',
            'entity_id' => $companies->id,
            'details' => "New Company $companies->companyname Added",
        ]);

        return redirect('admin/accountant/register_company')->with('success','Company Registered Successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $companies = RegisterCompany::where('id', $id)->first();
        $companyService = CompanyServiceCode::where('company_id', $id)->orderBy('order_no', 'asc')->get();
        $gstNumbers = GstNumber::where('company_id', $id)->get();
        return view('admin.accountant.register_company.edit', compact('companies', 'companyService', 'gstNumbers'));
    }


    // public function checkUnique(Request $request)
    // {
    //     $field = $request->fieldType;
    //     $value = $request->fieldValue;

    //     if ($field === 'gstnumber') {
    //         $exists = DB::table('gst_numbers')->where('gstnumber', $value)->exists();
    //     } elseif ($field === 'pannumber') {
    //         $exists = DB::table('register_companies')->where('pannumber', $value)->exists();
    //     } else {
    //         return response()->json(['exists' => false]);
    //     }

    //     if ($exists) {
    //         return response()->json([
    //             'exists' => true,
    //             'message' => ucfirst(str_replace('number', ' Number', $field)) . ' already exists.',
    //         ]);
    //     }

    //     return response()->json(['exists' => false]);
    // }



    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'companyname' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'email' => 'nullable|email|unique:register_companies,email,'. $id,
            'phone' => 'nullable|numeric|digits:10',
            'inv_no_name' => 'required|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'required|string|max:255',
            'gstnumber' => 'required|array|min:1',
            'gstnumber.*' => 'required|string|max:255',
            'pannumber' => 'required',
            'order_no.*' => 'required|string|max:255',
            'service_code.*' => 'required|string',
            'job_description.*' => 'required|string',
            'uom.*' => 'required|string',
            'price.*' => 'required|numeric',
        ]);
        $companies = RegisterCompany::find($id);
        $companies->companyname = $request->companyname;
        $companies->state = $request->state;
        $companies->inv_no_name = $request->inv_no_name;
        $companies->vendor_code = $request->vendor_code;
        $companies->email = $request->email;
        $companies->address_1 = $request->address_1;
        $companies->address_2 = $request->address_2;
        $companies->address_3 = $request->address_3;
        $companies->is_lut = $request->is_lut;
        $companies->lut_no = $request->lut_no;
        $companies->doa = $request->doa;
        $companies->update();

        $gids = $request->input('gid');
        $gstnumbers = $request->input('gstnumber');
        // dd($gids, $gstnumbers);

        foreach ($gstnumbers as $index => $gstnumber) {
            $gid = $gids[$index] ?? null;

            if ($gid) {
                // Update existing
                GstNumber::updateOrCreate(
                    ['id' => $gid],
                    ['gstnumber' => $gstnumber]
                );
            } else {
                // Create new
                GstNumber::create([
                    'company_id' => $companies->id,
                    'gstnumber' => $gstnumber
                ]);
            }
        }



        if ($companies) {
            foreach ($request->job_description as $key => $description) {
                $CompanyServiceCode = [
                    'company_id'      => $companies->id,
                    'order_no'        => $request->order_no[$key] ?? null,
                    'job_description' => $description,
                    'service_code'    => $request->service_code[$key] ?? null,
                    'uom'             => $request->uom[$key] ?? null,
                    'price'           => $request->price[$key] ?? null,
                ];

                $oldData = [];
                if($request->sr_no[$key] > 0){
                    $existingRecord = CompanyServiceCode::find($request->sr_no[$key]);
                    if ($existingRecord) {
                        $oldData = $existingRecord->toArray();
                    }
                }

                // Use updateOrCreate() to update if exists, otherwise insert
                $existingRecord = CompanyServiceCode::updateOrCreate(
                    [
                        'id'   => $request->sr_no[$key]
                    ],
                    $CompanyServiceCode
                );

                $logAction = (!empty($request->sr_no[$key]) && $request->sr_no[$key] > 0) ? 'Updated Service Code' : 'Created Service Code';

                // Log database action
                Log::info($logAction, [
                    'entity_id' => $existingRecord->id,
                    'old_data' => isset($oldData) ? $oldData : null,
                    'new_data' => $CompanyServiceCode
                ]);

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => $logAction,
                    'entity_type' => 'CompanyServiceCode',
                    'entity_id' => $existingRecord->id,
                    'old_data' => isset($oldData) ? json_encode($oldData) : null,
                    'new_data' => json_encode($CompanyServiceCode),
                    'details' => ($logAction === 'Updated Service Code')
                        ? "Service Code '" . (isset($oldData['service_code']) ? $oldData['service_code'] : '') .
                          "' updated to '" . (isset($CompanyServiceCode['service_code']) ? $CompanyServiceCode['service_code'] : '') .
                          "' for Company {$companies->companyname}"
                        : "New Service Code '{$existingRecord->service_code}' created for Company {$companies->companyname}"
                ]);

            }
        }

        return redirect()->back()->with('success','Company Registered Detail Update Successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $companies = DB::table('register_companies')
        ->leftJoin('company_service_codes','register_companies.id', '=','company_service_codes.company_id')
        ->where('register_companies.id', $id);
        DB::table('company_service_codes')->where('company_id', $id)->delete();
        $companies->delete();
        return back()->with('success','Registered Company Deleted Successfully.');
    }

    public function serviceDestroy(Request $request)
    {
        $serviceCodeId = $request->input('id');
        $isUsed = SummaryProduct::where('service_code_id', $serviceCodeId)->exists();

        if ($isUsed) {
            return response()->json(['status' => 'error', 'message' => 'You cannot delete this service code because it is used in summary products.']);
        } else {
            CompanyServiceCode::find($serviceCodeId)->delete();
            return response()->json(['status' => 'success', 'message' => 'Service code deleted successfully.']);
        }
    }

    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if (is_null($id) || is_null($status)) {
            return response()->json(['success' => false, 'message' => 'Invalid ID or status value.']);
        }

        $item = RegisterCompany::find($id);
        if ($item) {
            $item->com_status = $status;
            $item->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.', 'status' => $item->com_status]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

    public function Gstdestroy(Request $request)
    {
        $gstId = $request->input('gid'); // Get the GST ID from the request

        // Check if the GST number exists
        $gst = GstNumber::find($gstId);
        if (!$gst) {
            return response()->json(['status' => 'error', 'message' => 'GST Number not found.'], 404);
        }

        // Check if the GST number is used in the summary table
        $gstUsed = Summary::where('gst_id', $gstId)->exists();
        if ($gstUsed) {
            return response()->json(['status' => 'error', 'message' => 'You cannot delete this GST Number because it is used in summary products.']);
        }

        // If not used, delete it
        $gst->delete();
        return response()->json(['status' => 'success', 'message' => 'GST Number deleted successfully.']);
    }



}
