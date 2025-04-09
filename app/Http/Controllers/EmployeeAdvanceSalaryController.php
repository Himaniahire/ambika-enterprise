<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAdvanceSalary;
use App\Models\Employee;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeAdvanceSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employeeAdvanceSalary = EmployeeAdvanceSalary::with('getEmployee')
                ->where('status', '=', '1')
                ->select('id', 'emp_id', 'advance_date', 'advance_amount');

            return DataTables::of($employeeAdvanceSalary)
                ->addIndexColumn() // Adds the Sr. No. column
                ->editColumn('advance_date', function($row) {
                    return Carbon::parse($row->advance_date)->format('d-m-Y');
                })
                ->addColumn('employee_name', function($row) {
                    return $row->getEmployee->first_name . ' ' . $row->getEmployee->father_name . ' ' . $row->getEmployee->last_name;
                })
                ->make(true);
        }

        $employees = Employee::where('status', '=', '1')
            ->where('emp_type', '=', 'Site Employee')
            ->get();

        return view('admin.employee.employee_advance_salary.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'emp_id' => 'required',
            'advance_date' => 'required',
            'advance_amount' => 'required',
        ]);

        // Save the new advance record
        $employeeAdvanceSalary = new EmployeeAdvanceSalary();
        $employeeAdvanceSalary->emp_id = $request->emp_id;
        $employeeAdvanceSalary->advance_date = $request->advance_date;
        $employeeAdvanceSalary->advance_amount = $request->advance_amount;
        $employeeAdvanceSalary->note = $request->note;
        $employeeAdvanceSalary->save();

        // Calculate the sum of advance_amount for the given emp_id
        $totalAdvance = EmployeeAdvanceSalary::where('emp_id', $request->emp_id)
                        ->sum('advance_amount');

        // Update the employees table with the calculated sum
        Employee::where('id', $request->emp_id)
                ->update(['advance' => $totalAdvance]);

        return back()->with('success','Employee Advance Salary added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeAdvanceSalary $employeeAdvanceSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAdvanceSalary $employeeAdvanceSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAdvanceSalary $employeeAdvanceSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAdvanceSalary $employeeAdvanceSalary)
    {
        //
    }
}
