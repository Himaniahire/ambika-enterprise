<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\RegisterCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use DB;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $today = Carbon::today();
    //     $employeeAttendances = EmployeeAttendance::whereDate('attendance_date', $today)->get();
    //     return view('admin.employee.employee_attendance.index', compact('employeeAttendances'));
    // }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $yesterday = Carbon::yesterday();
            $query = EmployeeAttendance::whereDate('attendance_date', $yesterday)
                ->with(['getEmployee', 'getCompany']);
    
            return DataTables::of($query)
    ->addIndexColumn() // ✅ This adds DT_RowIndex automatically
    ->addColumn('employee_name', function ($employee) {
        return optional($employee->getEmployee)->first_name . ' ' .
               optional($employee->getEmployee)->father_name . ' ' .
               optional($employee->getEmployee)->last_name;
    })
    ->addColumn('emp_code', function ($employee) {
        return optional($employee->getEmployee)->emp_code;
    })
    ->addColumn('company_name', function ($employee) {
        return optional($employee->getCompany)->companyname;
    })
    ->addColumn('attendance_date', function ($employee) {
        return Carbon::parse($employee->attendance_date)->format('d-m-Y');
    })
    ->addColumn('status', function ($employee) {
        $statusLabels = [
            0 => '<span class="badge bg-danger">Absent</span>',
            1 => '<span class="badge bg-success">Present</span>',
            2 => '<span class="badge bg-warning">Half Day</span>',
            3 => '<span class="badge bg-primary">Holiday</span>',
        ];
        $statusText = $statusLabels[$employee->status] ?? 'Unknown';

        if (in_array($employee->status, [1, 2, 3])) {
            $statusText .= ' OT: ' . $employee->over_time;
        }

        return $statusText;
    })
    ->rawColumns(['status']) // ✅ Allows HTML rendering
    ->make(true);

        }
    
        return view('admin.employee.employee_attendance.index');
    }

    public function getEmployeeDetails($companyId)
    {
        $employees = Employee::where('company_id', $companyId)->where('status','=' ,'1')->get();
        return response()->json($employees);
    }
    
    public function checkAttendance(Request $request)
    {
        $companyId = $request->input('company_id');

        // Fetch attendance dates for the company
        $attendanceDates = EmployeeAttendance::where('company_id', $companyId)
            ->pluck('attendance_date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            });

        return response()->json(['dates' => $attendanceDates]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('status','=' ,'1')->get();
        $companies = RegisterCompany::get();
        return view('admin.employee.employee_attendance.add',compact('employees','companies'));
    }

    public function getEmployeesByCompany(Request $request)
    {
        $companyId = $request->input('company_id');

        // Fetch employees for the selected company with pagination
        $employees = Employee::where('company_id', $companyId)->get();

        return $employees;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = $request->input('company_id');
        $attendanceDate = $request->input('stored_date');
        $statuses = $request->input('status');
        $presentOvertimes = $request->input('present_over_time', []);
        $halfdayOvertimes = $request->input('half_day_over_time', []);
        $holidayOvertimes = $request->input('holiday_over_time', []);

        // Check if the attendance date is a Sunday
        $isSunday = Carbon::parse($attendanceDate)->isSunday();

        foreach ($statuses as $employeeId => $status) {
            // Fetch employee data to check income_type
            $employee = Employee::find($employeeId);

            if (!$employee) {
                continue; // Skip if employee not found
            }

            // Check if an attendance record already exists for this employee on the specified attendance date
            $existingAttendance = EmployeeAttendance::where('attendance_date', $attendanceDate)
                ->where('emp_id', $employeeId)
                ->first();

            // Determine the over_time value based on status
            $overTimeValue = $this->calculateOverTime($status, $presentOvertimes, $halfdayOvertimes, $holidayOvertimes, $employeeId);

            // Determine what to save based on conditions
            $saveData = [
                'company_id' => $companyId,
                'attendance_date' => $attendanceDate,
                'emp_id' => $employeeId,
                'status' => $status,
                'over_time' => $overTimeValue,
            ];

            // Handle specific cases for Sunday and non-Sunday
            if ($isSunday) {
                $this->handleSundayAttendance($employee, $existingAttendance, $saveData);
            } else {
                $this->handleNonSundayAttendance($existingAttendance, $saveData);
            }
        }

        return response()->json(['message' => 'Attendance saved successfully!']);
    }

    private function calculateOverTime($status, $presentOvertimes, $halfdayOvertimes, $holidayOvertimes, $employeeId)
    {
        $overTimeValue = 0;

        switch ($status) {
            case 1:
                $overTimeValue = isset($presentOvertimes[$employeeId]) ? $presentOvertimes[$employeeId] : 0;
                break;
            case 2:
                $overTimeValue = isset($halfdayOvertimes[$employeeId]) ? $halfdayOvertimes[$employeeId] : 0;
                break;
            case 3:
                $overTimeValue = isset($holidayOvertimes[$employeeId]) ? $holidayOvertimes[$employeeId] : 0;
                break;
            default:
                break;
        }

        return $overTimeValue;
    }

    private function handleSundayAttendance($employee, $existingAttendance, $saveData)
    {
        if ($employee->income_type == 1) {
            // On Sunday, if income_type is 1, save both status and over_time
            $this->saveOrUpdateAttendance($existingAttendance, $saveData);
        } elseif ($employee->income_type == 0) {
            // On Sunday, if income_type is 0, save only over_time
            $saveData['status'] = 4; // Assuming status 4 means no status on Sunday
            $this->saveOrUpdateAttendance($existingAttendance, $saveData);
        }
    }

    private function handleNonSundayAttendance($existingAttendance, $saveData)
    {
        // On non-Sundays, save status and over_time
        $this->saveOrUpdateAttendance($existingAttendance, $saveData);
    }

    private function saveOrUpdateAttendance($existingAttendance, $saveData)
    {
        if ($existingAttendance) {
            // Update existing record
            $existingAttendance->update($saveData);
        } else {
            // Create new record
            EmployeeAttendance::create($saveData);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAttendance $employeeAttendance)
    {
        //
    }

    public function attendanceEdit(EmployeeAttendance $employeeAttendance)
    {
        $employees = Employee::where('status','=' ,'1')->get();
        $companies = RegisterCompany::get();
        return view('admin.employee.employee_attendance.attendance_edit', compact('employees','companies'));
    }

    public function fetchAttendanceByDate(Request $request)
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
     * Update the specified resource in storage.
     */
    public function empUpdate(Request $request)
    {
        $companyId = $request->input('hidden_company_id');
        $attendanceDate = $request->input('hidden_attendance_date');
        $statuses = $request->input('status', []);
        $ids = $request->input('id', []);
        $presentOvertimes = $request->input('present_over_time', []);
        $halfdayOvertimes = $request->input('half_day_over_time', []);
        $holidayOvertimes = $request->input('holiday_over_time', []);
        
        if (empty($statuses)) {
            return redirect()->back()->with('error', 'No Data Found');
        }


        foreach ($statuses as $originalAttendanceId => $status) {
            if (isset($ids[$originalAttendanceId])) {
                $attendanceId = $ids[$originalAttendanceId];

                $existingAttendance = EmployeeAttendance::where('id', $attendanceId)
                    ->where('attendance_date', $attendanceDate)
                    ->first();

                if ($existingAttendance) {
                    $updated = false;

                    if ($existingAttendance->status != $status) {
                        $existingAttendance->status = $status;
                        $updated = true;
                    }

                    if ($status == 1) { // Assuming status 1 represents 'Present'
                        if (isset($presentOvertimes[$originalAttendanceId])) {
                            $existingAttendance->over_time = $presentOvertimes[$originalAttendanceId];
                            $updated = true;
                        }
                    } elseif ($status == 3) { // Assuming status 3 represents 'Holiday'
                        if (isset($holidayOvertimes[$originalAttendanceId])) {
                            $existingAttendance->over_time = $holidayOvertimes[$originalAttendanceId];
                            $updated = true;
                        }
                    } elseif ($status == 0) { // Assuming status 0 represents 'Absent'
                            $existingAttendance->over_time = 0;
                            $updated = true;
                    } elseif ($status == 2) { // Assuming status 2 represents 'Half Day'
                        if (isset($halfdayOvertimes[$originalAttendanceId])) {
                            $existingAttendance->over_time = $halfdayOvertimes[$originalAttendanceId];
                            $updated = true;
                        }
                    }

                    if ($updated = true) {
                        $existingAttendance->save();
                        $success = true; // Set success to true if any updates were made
                        Log::info('Updated Attendance for ID ' . $attendanceId . ': Status ' . $status . ', Overtime ' . $existingAttendance->over_time);
                    } else {
                        return redirect()->back()->with('error', 'No Data Found');
                    }
                } else {
                    Log::warning('Attendance not found for ID ' . $attendanceId . ' and Date ' . $attendanceDate);
                }
            } else {
                Log::warning('No ID found for Employee ID ' . $originalAttendanceId);
            }
        }


    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        //
    }
}
