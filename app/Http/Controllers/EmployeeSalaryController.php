<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAdvanceSalary;
use App\Models\RegisterCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        // Parse month and year
        $month = date('m', strtotime($salary_month));
        $year = date('Y', strtotime($salary_month));

        // Fetch employees with post and category
        $employees = Employee::where('company_id', $company_id)
            ->with(['getEmployeePost.getEmployeeCategory'])
            ->get();

        $attendanceData = [];

        // Fetch all holidays for the given month and company
        $holidays = Holiday::whereMonth('holiday_date', $month)
            ->whereYear('holiday_date', $year)
            ->pluck('holiday_date') // Get list of dates
            ->toArray();

        foreach ($employees as $employee) {
            // Attendance records for the employee
            $attendanceStats = EmployeeAttendance::where('company_id', $company_id)
                ->where('emp_id', $employee->id)
                ->whereMonth('attendance_date', $month)
                ->whereYear('attendance_date', $year)
                ->where('is_paid', false)
                ->get();

            $leaveDates = $attendanceStats->where('status', 0)->pluck('attendance_date')->map(function ($date) {
                return date('Y-m-d', strtotime($date));
            })->toArray();

            $presentCount = $attendanceStats->where('status', 1)->count();
            $leaveCount   = count($leaveDates);
            $totalOt      = $attendanceStats->sum('over_time');

            // Process each holiday for sandwich leave
            foreach ($holidays as $holidayDate) {
                $holiday = date('Y-m-d', strtotime($holidayDate));
                $prevDay = date('Y-m-d', strtotime("$holiday -1 day"));
                $nextDay = date('Y-m-d', strtotime("$holiday +1 day"));

                // If both prev and next days are leaves, and holiday isn't already counted
                if (in_array($prevDay, $leaveDates) && in_array($nextDay, $leaveDates) && !in_array($holiday, $leaveDates)) {
                    $leaveCount++; // Add this holiday as sandwich leave
                }
            }

            // Get advance salary
            $advanceAmount = EmployeeAdvanceSalary::where('emp_id', $employee->id)->sum('advance_amount');

            // Push data
            $attendanceData[] = [
                'emp_id'         => $employee->id,
                'total_present'  => $presentCount,
                'total_leave'    => $leaveCount,
                'total_ot'       => $totalOt,
                'advance_amount' => $advanceAmount,
            ];
        }

        return response()->json([
            'employees'      => $employees,
            'attendanceData' => $attendanceData,
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



    public function store(Request $request)
    {
        $data = $request->all();

        if (!isset($data['emp_id']) || !is_array($data['emp_id'])) {
            return redirect()->back()->with('error', 'No employee data found.');
        }

        // Check if salary is already generated for all employees
        $alreadyGenerated = true;

        foreach ($data['emp_id'] as $emp_id) {
            $unpaidCount = EmployeeAttendance::where('company_id', $request->hidden_com_id)
                ->where('emp_id', $emp_id)
                ->whereMonth('attendance_date', date('m', strtotime($request->hidden_salary_month)))
                ->whereYear('attendance_date', date('Y', strtotime($request->hidden_salary_month)))
                ->where('is_paid', false)
                ->count();

            if ($unpaidCount > 0) {
                $alreadyGenerated = false;
                break; // No need to check further, at least one is unpaid
            }
        }

        if ($alreadyGenerated) {
            return redirect()->back()->with('error', 'Salary already generated. Check the salary report.');
        }

        foreach ($data['emp_id'] as $index => $emp_id) {
            $employeeSalary = EmployeeSalary::where('com_id', $request->hidden_com_id)
                ->where('salary_month', $request->hidden_salary_month)
                ->where('emp_id', $emp_id)
                ->first();

            if ($employeeSalary) {
                $employeeSalary->update([
                    'total_present' => $data['total_present'][$index] ?? 0,
                    'total_leave' => $data['total_leave'][$index] ?? 0,
                    'total_ot' => $data['total_ot'][$index] ?? 0,
                    'deduct_advance' => $data['deduct_advance'][$index] ?? 0,
                    'salary' => $data['salary'][$index] ?? 0,
                    'additional_amount' => $data['additional_amount'][$index] ?? 0,
                    'note' => $data['note'][$index] ?? 0,
                ]);
            } else {
                EmployeeSalary::create([
                    'com_id' => $request->hidden_com_id,
                    'salary_month' => $request->hidden_salary_month,
                    'emp_id' => $emp_id,
                    'total_present' => $data['total_present'][$index] ?? 0,
                    'total_leave' => $data['total_leave'][$index] ?? 0,
                    'total_ot' => $data['total_ot'][$index] ?? 0,
                    'deduct_advance' => $data['deduct_advance'][$index] ?? 0,
                    'salary' => $data['salary'][$index] ?? 0,
                    'additional_amount' => $data['additional_amount'][$index] ?? 0,
                    'note' => $data['note'][$index] ?? 0,
                ]);
            }

            EmployeeAttendance::where('company_id', $request->hidden_com_id)
                ->where('emp_id', $emp_id)
                ->whereMonth('attendance_date', date('m', strtotime($request->hidden_salary_month)))
                ->whereYear('attendance_date', date('Y', strtotime($request->hidden_salary_month)))
                ->where('is_paid', false)
                ->update(['is_paid' => true]);

            $employee = Employee::find($emp_id);
            if ($employee) {
                $newAdvance = $employee->advance - ($data['deduct_advance'][$index] ?? 0);

                if ($newAdvance < 0) {
                    $newAdvance = 0;
                }

                $employee->update(['advance' => $newAdvance]);
            }
        }

        return redirect()->back()->with('success', 'Employee salaries saved successfully.');
    }



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
