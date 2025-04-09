<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAdvanceSalary;
use App\Models\RegisterCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = RegisterCompany::get();
        return view('admin.employee.employee_salary.add',compact('companies'));
    }

    public function getEmployeeData(Request $request)
    {
        $company_id = $request->input('company_id');
        $salary_month = $request->input('salary_month');
    
        // Parse the month and year safely
        $month = date('m', strtotime($salary_month));
        $year = date('Y', strtotime($salary_month));
    
        // Fetch employees with their related post and category
        $employees = Employee::where('company_id', $company_id)
            ->with(['getEmployeePost.getEmployeeCategory']) // Ensure relationships are properly defined in model
            ->get();
    
        $attendanceData = [];
    
        foreach ($employees as $employee) {
            // Fetch attendance data per employee
            $attendanceStats = EmployeeAttendance::where('company_id', $company_id)
                ->where('emp_id', $employee->id)
                ->whereMonth('attendance_date', $month)
                ->whereYear('attendance_date', $year)
                ->get();
            // dd($attendanceStats);
    
            // Calculate stats
            $totalPresent = $attendanceStats->where('status', 1)->count();
            $totalLeave   = $attendanceStats->where('status', 0)->count();
            $totalOt      = $attendanceStats->sum('over_time'); // Make sure 'over_time' column exists and is numeric
    
            // Fetch advance amount
            $advanceAmount = EmployeeAdvanceSalary::where('emp_id', $employee->id)->sum('advance_amount');
    
            // Push to array
            $attendanceData[] = [
                'emp_id'         => $employee->id,
                'total_present'  => $totalPresent,
                'total_leave'    => $totalLeave,
                'total_ot'       => $totalOt,
                'advance_amount' => $advanceAmount,
            ];
        }
    
        return response()->json([
            'employees'      => $employees,
            'attendanceData' => $attendanceData
        ]);
    }


    public function fetchEmployeeByMonth(Request $request)
    {
        $attendance_date = $request->input('attendance_date');
        $company_id = $request->input('company_id');

        $attendances = DB::table('employee_attendances')
        ->join('employees', 'employee_attendances.emp_id', '=', 'employees.id')
        ->where('employee_attendances.attendance_date', $attendance_date)
        ->where('employees.company_id', $company_id)
        ->select(
            'employee_attendances.id as id',
            'employee_attendances.emp_id as employee_id',
            'employees.first_name',
            'employees.father_name',
            'employees.last_name',
            'employees.emp_code',
            'employee_attendances.status',
            'employee_attendances.over_time'
        )
        ->get();

        return response()->json($attendances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        if (!isset($data['emp_id']) || !is_array($data['emp_id'])) {
            return redirect()->back()->with('error', 'No employee data found.');
        }

        foreach ($data['emp_id'] as $index => $emp_id) {
            $employeeSalary = EmployeeSalary::where('com_id', $request->hidden_com_id)
                ->where('salary_month', $request->hidden_salary_month)
                ->where('emp_id', $emp_id)
                ->first();

            if ($employeeSalary) {
                $employeeSalary->update([
                    'total_present' => $data['total_present'][$index],
                    'total_leave' => $data['total_leave'][$index],
                    'total_ot' => $data['total_ot'][$index],
                    'deduct_advance' => $data['deduct_advance'][$index],
                    'salary' => $data['salary'][$index],
                    'additional_amount' => $data['additional_amount'][$index],
                    'note' => $data['note'][$index],
                ]);
            } else {
                EmployeeSalary::create([
                    'com_id' => $request->hidden_com_id,
                    'salary_month' => $request->hidden_salary_month,
                    'emp_id' => $emp_id,
                    'total_present' => $data['total_present'][$index],
                    'total_leave' => $data['total_leave'][$index],
                    'total_ot' => $data['total_ot'][$index],
                    'deduct_advance' => $data['deduct_advance'][$index],
                    'salary' => $data['salary'][$index],
                    'additional_amount' => $data['additional_amount'][$index],
                    'note' => $data['note'][$index],
                ]);
            }

            $employee = Employee::find($emp_id);
            if ($employee) {
                $newAdvance = $employee->advance - $data['deduct_advance'][$index];
            
                if ($newAdvance < 0) {
                    $newAdvance = 0;
                }
            
                $employee->update(['advance' => $newAdvance]);
            }

        }

        return redirect()->back()->with('success', 'Employee salaries saved successfully.');
    }
    
//     public function store(Request $request)
//     {
//     $data = $request->all();

//     if (!isset($data['emp_id']) || !is_array($data['emp_id'])) {
//         return redirect()->back()->with('error', 'No employee data found.');
//     }

//     foreach ($data['emp_id'] as $index => $emp_id) {
//         $employeeSalary = EmployeeSalary::where('com_id', $request->hidden_com_id)
//             ->where('salary_month', $request->hidden_salary_month)
//             ->where('emp_id', $emp_id)
//             ->first();

//         $salaryData = [
//             'total_present' => $data['total_present'][$index] ?? 0,
//             'total_leave' => $data['total_leave'][$index] ?? 0,
//             'total_ot' => $data['total_ot'][$index] ?? 0,
//             'deduct_advance' => $data['deduct_advance'][$index] ?? 0,
//             'salary' => $data['salary'][$index] ?? 0,
//             'additional_amount' => $data['additional_amount'][$index] ?? 0,
//             'note' => $data['note'][$index] ?? null,
//         ];

//         if ($employeeSalary) {
//             $employeeSalary->update($salaryData);
//         } else {
//             EmployeeSalary::create(array_merge($salaryData, [
//                 'com_id' => $request->hidden_com_id,
//                 'salary_month' => $request->hidden_salary_month,
//                 'emp_id' => $emp_id,
//             ]));
//         }

//         $employee = Employee::find($emp_id);
//         if ($employee) {
//             $newAdvance = $employee->advance - ($data['deduct_advance'][$index] ?? 0);
//             $employee->update(['advance' => max($newAdvance, 0)]);
//         }
//     }

//     return redirect()->back()->with('success', 'Employee salaries saved successfully.');
// }



    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        //
    }
}
