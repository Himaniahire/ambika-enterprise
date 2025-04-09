<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Yajra\DataTables\DataTables;
use App\Models\RegisterCompany;
use Illuminate\Support\Facades\Log;

class EmployeeCompanyTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = RegisterCompany::get();
        $employees = Employee::where("emp_type","Site Employee")->where("status","1")->get();
        return view('admin.employee.employee_company_transfer.index',compact('employees','companies'));
    }

    // public function getData()
    // {
    //     $employees = Employee::where("emp_type", "Site Employee")
    //                       ->where("status", "1")
    //                       ->get();

    //     return DataTables::of($employees)
    //         ->addIndexColumn()
    //         ->addColumn('company_name', function($employee) {
    //             $options = '<option value="">Select Company</option>'; // Default option
    //             foreach ($employee->companies as $company) {
    //                 $selected = $employee->company_id == $company->id ? 'selected' : '';
    //                 $options .= '<option value="' . $company->id . '" ' . $selected . '>' . $company->companyname . '</option>';
    //             }
    //             return '<select style="width: 100%" class="form-control company-select" name="company_id">' . $options . '</select>';
    //         })
    //         ->addColumn('employee_name', function($employee) {
    //             return $employee->first_name . ' ' . $employee->father_name . ' ' . $employee->last_name;
    //         })
    //         ->addColumn('employee_code', function($employee) {
    //             return $employee->emp_code;
    //         })
    //         ->addColumn('action', function($employee) {
    //             return '<form action="' . route('employee_company_transfer.update', $employee->id) . '" method="POST">
    //                         ' . csrf_field() . method_field('PUT') . '
    //                         <input type="hidden" name="id" value="' . $employee->id . '">
    //                         <button class="btn" type="submit">
    //                             <img src="' . asset('admin_assets/index_icon/knowledge.png') . '" style="width: 30px;" alt="">
    //                         </button>
    //                     </form>';
    //         })
    //         ->rawColumns(['company_name', 'action'])
    //         ->make(true);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::with('getCompany')->find($id);
        if ($employee->update([
            'company_id' => $request->company_id,
        ])) {
            return redirect()->back()->with('success', 'Employee ' . $employee->first_name . ' ' . $employee->father_name . ' ' . $employee->last_name . ' Transferred Company Successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to transfer employee.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
