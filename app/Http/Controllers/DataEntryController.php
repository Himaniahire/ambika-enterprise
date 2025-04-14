<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeAttendanceExport;
use App\Exports\EmployeeSalaryExport;
use App\Models\RegisterCompany;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAdvanceSalary;
use App\Models\EmployeeSalary;
use App\Models\Employee;
use Carbon\Carbon;
use DataTables;
use PDF;

class DataEntryController extends Controller
{
    public function index()
    {
        return view('admin.employee.index');
    }

    public function attendanceReport()
    {
        $companies = RegisterCompany::where('com_status','1')->get();
        return view('admin.employee.reports.attendance_report',compact('companies'));
    }

    public function salaryReport()
    {
        $companies = RegisterCompany::where('com_status','1')->get();
        return view('admin.employee.reports.salary_report',compact('companies'));
    }

    public function EmpAdvanceReport()
    {
        $employee = Employee::where('status','1')->get();
        return view('admin.employee.reports.emp_advance_report',compact('employee'));
    }

    public function EmpSalaryReport()
    {
        return view('admin.employee.reports.emp_salary_report');
    }

    public function EmpJoinLeaveReport()
    {
        $employee = Employee::get();
        return view('admin.employee.reports.emp_join_leave_report',compact('employee'));
    }

    public function attendanceExport(Request $request)
    {
        $month = $request->input('month');
        $company_id = $request->input('company_id');
        $exportType = $request->input('export_type'); // Get the export type from the form

        if (empty($month)) {
            return redirect()->back()->withInput()->withErrors('Month and year are required.');
        }

        $monthDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();

        $query = EmployeeAttendance::with(['getEmployee', 'getEmployee.getEmployeePost'])
            ->whereDate('attendance_date', '>=', $monthDate);

        if (!empty($company_id)) {
            $query->where('company_id', $company_id);
        }

        $attendances = $query->get();

        $companyName = RegisterCompany::where('id', $company_id)->value('companyname');
        $data = compact('attendances', 'monthDate', 'month', 'companyName', 'exportType');

        if ($exportType === 'excel') {
            return Excel::download(new EmployeeAttendanceExport($data), 'employee_attendance.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('admin.employee.employee_attendance.employee_attendance', $data)
                ->setPaper('A2', 'landscape');
            return $pdf->stream('employee_attendance.pdf');
        } else {
            return redirect()->back()->with('error', 'Invalid export type selected.');
        }
    }

    public function salaryExport(Request $request)
    {
        $month = $request->input('month');
        $company_id = $request->input('company_id');
        $exportType = $request->input('export_type'); // Get the export type from the form

        // Basic input validation
        if (empty($month)) {
            return redirect()->back()->withInput()->withErrors('Month and year are required.');
        }

        // Parse the selected month and year
        $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();

        // Query based on month, year, and optionally company_id
        $query = EmployeeSalary::with(['getEmployee', 'getEmployee.getEmployeePost'])
            ->where('salary_month', '>=', $monthDate);

        if (!empty($company_id)) {
            $query->where('com_id', $company_id);
        }

        $salaries = $query->get()->map(function($salary) {
            // Calculate the total advance amount for the employee
            $totalAdvance = EmployeeAdvanceSalary::where('emp_id', $salary->emp_id)->sum('advance_amount');
            $salary->total_advance = $totalAdvance;
            return $salary;
        });

        // Fetch the company name using the company_id
        $companyName = $company_id ? RegisterCompany::where('id', $company_id)->value('companyname') : null;

        $data = [
            'salaries' => $salaries,
            'monthDate' => $monthDate,
            'month' => $month,
            'companyName' => $companyName,
            'exportType'  => $exportType,
        ];

        if ($exportType === 'excel') {
            return Excel::download(new EmployeeSalaryExport($data), 'employee_salary.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('admin.employee.employee_salary.employee_salary', $data)
                ->setPaper('A1', 'landscape');
            return $pdf->stream('employee_salary.pdf');
        } else {
            return redirect()->back()->with('error', 'Invalid export type selected.');
        }
    }

    public function fetchEmpAdvanceReport(Request $request)
    {
        $empId = $request->emp_id;

        // Join employee_advance_salaries with employees and employee_salaries tables
        $employeeAdvanceSalaries = EmployeeAdvanceSalary::where('employee_advance_salaries.emp_id', $empId)
            ->join('employees', 'employee_advance_salaries.emp_id', '=', 'employees.id')
            ->leftJoin('employee_salaries', 'employee_advance_salaries.emp_id', '=', 'employee_salaries.emp_id')
            ->select(
                'employee_advance_salaries.*',
                'employees.first_name',
                'employees.father_name',
                'employees.last_name',
                'employee_salaries.salary_month',
                'employee_salaries.deduct_advance',
                'employees.advance',
            )
            ->get();

        return DataTables::of($employeeAdvanceSalaries)
            ->addColumn('advance_date', function($row) {
                return Carbon::parse($row->advance_date)->format('d-m-Y'); // Format the date to dd-mm-yyyy
            })
            ->addColumn('advance_amount', function($row) {
                return $row->advance_amount;
            })
            ->addColumn('salary_month', function($row) {
                return $row->salary_month
                    ? Carbon::parse($row->salary_month)->format('F Y') // Format to "Month Year" (e.g., January 2024)
                    : 'N/A';
            })
            ->addColumn('deduct_advance', function($row) {
                return $row->deduct_advance ? $row->deduct_advance : 'N/A'; // Handle cases where deduct_advance might be null
            })

            ->addColumn('advance', function($row) {
                return $row->advance ? $row->advance : 'N/A'; // Handle cases where advance might be null
            })
            ->make(true);
    }

    public function fetchEmpSalaryeport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Perform join between EmployeeSalary and employees table
        $salaries = EmployeeSalary::whereBetween('salary_month', [$startDate, $endDate])
            ->join('employees', 'employees.id', '=', 'employee_salaries.emp_id')  // Join with employees table
            ->select('employee_salaries.*', 'employees.first_name', 'employees.father_name', 'employees.last_name')
            ->get();

        return DataTables::of($salaries)
            ->addColumn('deduct_advance', function($row) {
                return $row->deduct_advance ? $row->deduct_advance : 'N/A';
            })
            ->addColumn('total_present', function($row) {
                return $row->total_present ? $row->total_present : 0;
            })
            ->addColumn('total_leave', function($row) {
                return $row->total_leave ? $row->total_leave : 0;
            })
            ->addColumn('total_ot', function($row) {
                return $row->total_ot ? $row->total_ot : 0;
            })
            ->addColumn('salary', function($row) {
                return $row->salary ? $row->salary : 'N/A';
            })
            ->addColumn('additional_amount', function($row) {
                return $row->additional_amount ? $row->additional_amount : 0;
            })
            ->addColumn('total_salary', function($row) {
                $totalSalary = $row->salary + $row->additional_amount;
                return $totalSalary ? $totalSalary : 'N/A';
            })
            ->addColumn('employee_name', function($row) {
                return $row->first_name . ' ' . $row->father_name . ' ' . $row->last_name;  // Concatenate full name
            })
            ->make(true);
    }

    public function fetchJoinLeaveport(Request $request)
{
    $employeeId = $request->id;

    if (empty($employeeId)) {
        // Fetch all employees if "All Employee Name" is selected or no specific employee is selected
        $employees = Employee::select('first_name', 'father_name', 'last_name', 'date_of_joining', 'leave_date')
                                ->get();

        // Format both date_of_joining and leave_date for each employee
        $employees->transform(function ($employee) {
            $employee->date_of_joining = Carbon::parse($employee->date_of_joining)->format('d-m-Y');
            $employee->leave_date = $employee->leave_date ? Carbon::parse($employee->leave_date)->format('d-m-Y') : null;
            return $employee;
        });

        return response()->json(['data' => $employees]);
    } else {
        // Fetch specific employee by id
        $employee = Employee::where('id', $employeeId)
                            ->select('first_name', 'father_name', 'last_name', 'date_of_joining', 'leave_date')
                            ->first();

        if ($employee) {
            // Format both date_of_joining and leave_date for the specific employee
            $employee->date_of_joining = Carbon::parse($employee->date_of_joining)->format('d-m-Y');
            $employee->leave_date = $employee->leave_date ? Carbon::parse($employee->leave_date)->format('d-m-Y') : null;
        }

        return response()->json(['data' => $employee ? [$employee] : []]);
    }
}


}
