<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\EmployeePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::where('emp_type', '=', 'Office Employee')->select('id', 'first_name', 'father_name', 'last_name', 'emp_code', 'phone_no', 'status');

            return DataTables::of($employees)
                ->addIndexColumn() // Adds the Sr. No. column
                ->addColumn('employee_name', function($row) {
                    return $row->first_name . ' ' . $row->father_name . ' ' . $row->last_name;
                })
                ->editColumn('status', function($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } elseif ($row->status == 0) {
                        return '<span class="badge bg-secondary">Inactive</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-danger">Terminated</span>';
                    } elseif ($row->status == 3) {
                        return '<span class="badge bg-warning">Resigned</span>';
                    }
                })
                ->addColumn('action', function($row){
                    $editUrl = route('employee_details.edit', $row->id);
                    $deleteUrl = route('employee_details.destroy', $row->id);

                    $csrfField = csrf_field();
                    $methodField = method_field('DELETE');

                    $actionBtns = <<<HTML
                    <ul class="list-unstyled hstack gap-1 mb-0">
                        <li>
                            <a class="btn btn-sm btn-soft-danger" href="$editUrl">
                                <i data-feather="edit"></i>
                            </a>
                        </li>
                        <form action="$deleteUrl" method="POST" style="display:inline;">
                            $csrfField
                            $methodField
                            <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm('Are you sure you want to delete this item?');">
                                <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                            </button>
                        </form>
                    </ul>
                    HTML;

                    return $actionBtns;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.employee.employee_details.index');
    }

    public function Site(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::where('emp_type', '=', 'Site Employee')
                ->select('id', 'first_name', 'father_name', 'last_name', 'emp_code', 'phone_no', 'status');

            return DataTables::of($employees)
                ->addIndexColumn() // Adds the Sr. No. column
                ->addColumn('employee_name', function($row) {
                    return $row->first_name . ' ' . $row->father_name . ' ' . $row->last_name;
                })
                ->editColumn('status', function($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } elseif ($row->status == 0) {
                        return '<span class="badge bg-secondary">Inactive</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-danger">Terminated</span>';
                    } elseif ($row->status == 3) {
                        return '<span class="badge bg-warning">Resigned</span>';
                    }
                })
                ->addColumn('action', function($row){
                    $editUrl = route('employee_details.edit', $row->id);
                    $deleteUrl = route('employee_details.destroy', $row->id);

                    $csrfField = csrf_field();
                    $methodField = method_field('DELETE');

                    $actionBtns = <<<HTML
                    <ul class="list-unstyled hstack gap-1 mb-0">
                        <li>
                            <a class="btn btn-sm btn-soft-danger" href="$editUrl">
                                <i data-feather="edit"></i>
                            </a>
                        </li>
                        <form action="$deleteUrl" method="POST" style="display:inline;">
                            $csrfField
                            $methodField
                            <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm('Are you sure you want to delete this item?');">
                                <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                            </button>
                        </form>
                    </ul>
                    HTML;

                    return $actionBtns;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.employee.employee_details.site');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeePost = EmployeePost::get();
        return view('admin.employee.employee_details.add',compact('employeePost'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'aadhar_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passbook' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'emp_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'police_verification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);
        $employee = new Employee([
            "emp_code" => $request->emp_code,
            "emp_post_id" => $request->emp_post_id,
            "date_of_joining" => $request->date_of_joining,
            "uan_no" => $request->uan_no,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "father_name" => $request->father_name,
            "date_of_birth" => $request->date_of_birth,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "days" => $request->days,
            "postal_code" => $request->postal_code,
            "phone_no" => $request->phone_no,
            "adhar_no" => $request->adhar_no,
            "pan_no" => $request->pan_no,
            "bank_name" => $request->bank_name,
            "branch" => $request->branch,
            "ifsc_code" => $request->ifsc_code,
            "account_no" => $request->account_no,
            "income_type" => $request->income_type,
            "income" => $request->income,
            "emp_type" => $request->emp_type,
        ]);
        $employee->save();

        $documents = [
            'emp_id' => $employee->id,
        ];

        if ($request->hasFile('aadhar_card')) {
            $aadharCardFile = $request->file('aadhar_card');
            $aadharCardFileName = $aadharCardFile->getClientOriginalName();
            $aadharCardFile->move(public_path('documents/aadhar_cards'), $aadharCardFileName);
            $documents['aadhar_card'] = $aadharCardFileName;
        }

        if ($request->hasFile('pan_card')) {
            $panCardFile = $request->file('pan_card');
            $panCardFileName = $panCardFile->getClientOriginalName();
            $panCardFile->move(public_path('documents/pan_cards'), $panCardFileName);
            $documents['pan_card'] = $panCardFileName;
        }

        if ($request->hasFile('passbook')) {
            $passbookFile = $request->file('passbook');
            $passbookFileName = $passbookFile->getClientOriginalName();
            $passbookFile->move(public_path('documents/passbooks'), $passbookFileName);
            $documents['passbook'] = $passbookFileName;
        }

        if ($request->hasFile('emp_photo')) {
            $empPhotoFile = $request->file('emp_photo');
            $empPhotoFileName = $empPhotoFile->getClientOriginalName();
            $empPhotoFile->move(public_path('documents/emp_photos'), $empPhotoFileName);
            $documents['emp_photo'] = $empPhotoFileName;
        }

        if ($request->hasFile('police_verification')) {
            $policeVerifyFile = $request->file('police_verification');
            $policeVerifyFileName = $policeVerifyFile->getClientOriginalName();
            $policeVerifyFile->move(public_path('documents/police_verifications'), $policeVerifyFileName);
            $documents['police_verification'] = $policeVerifyFileName;
        }

        // Save documents data
        if (!empty($documents)) {
            EmployeeDocument::create(array_merge(['emp_id' => $employee->id], $documents));
        }


        return redirect('admin/employee/employee_details')->with('success','Employee Registered Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::with('employeeDocument','getEmployeePost')->find($id);
        // dd($employee);
        $employeePost = EmployeePost::get();
        return view('admin.employee.employee_details.edit',compact('employee','employeePost'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'aadhar_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passbook' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'emp_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'police_verification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Find the employee record by ID
        $employee = Employee::findOrFail($id);

        // Update employee data
        $employee->update([
            "emp_code" => $request->emp_code,
            "emp_post_id" => $request->emp_post_id,
            "date_of_joining" => $request->date_of_joining,
            "uan_no" => $request->uan_no,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "father_name" => $request->father_name,
            "date_of_birth" => $request->date_of_birth,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "days" => $request->days,
            "status" => $request->status,
            "postal_code" => $request->postal_code,
            "phone_no" => $request->phone_no,
            "adhar_no" => $request->adhar_no,
            "pan_no" => $request->pan_no,
            "bank_name" => $request->bank_name,
            "branch" => $request->branch,
            "ifsc_code" => $request->ifsc_code,
            "account_no" => $request->account_no,
            "income_type" => $request->income_type,
            "income" => $request->income,
            "emp_type" => $request->emp_type,
        ]);

        // Handle document uploads
        $documents = [];
        if ($request->hasFile('aadhar_card')) {
            $aadharCardFile = $request->file('aadhar_card');
            $aadharCardFileName = $aadharCardFile->getClientOriginalName();
            $aadharCardFile->move(public_path('documents/aadhar_cards'), $aadharCardFileName);
            $documents['aadhar_card'] = $aadharCardFileName;
        }

        if ($request->hasFile('pan_card')) {
            $panCardFile = $request->file('pan_card');
            $panCardFileName = $panCardFile->getClientOriginalName();
            $panCardFile->move(public_path('documents/pan_cards'), $panCardFileName);
            $documents['pan_card'] = $panCardFileName;
        }

        if ($request->hasFile('passbook')) {
            $passbookFile = $request->file('passbook');
            $passbookFileName = $passbookFile->getClientOriginalName();
            $passbookFile->move(public_path('documents/passbooks'), $passbookFileName);
            $documents['passbook'] = $passbookFileName;
        }

        if ($request->hasFile('emp_photo')) {
            $empPhotoFile = $request->file('emp_photo');
            $empPhotoFileName = $empPhotoFile->getClientOriginalName();
            $empPhotoFile->move(public_path('documents/emp_photos'), $empPhotoFileName);
            $documents['emp_photo'] = $empPhotoFileName;
        }

        if ($request->hasFile('police_verification')) {
            $policeVerifyFile = $request->file('police_verification');
            $policeVerifyFileName = $policeVerifyFile->getClientOriginalName();
            $policeVerifyFile->move(public_path('documents/police_verifications'), $policeVerifyFileName);
            $documents['police_verification'] = $policeVerifyFileName;
        }

        // Update documents data if any new documents were uploaded
        if (!empty($documents)) {
            $employeeDocument = EmployeeDocument::updateOrCreate(
                ['emp_id' => $employee->id],
                $documents
            );
            // dd($employeeDocument);
        }

        return redirect('admin/employee/employee_details')->with('success','Employee Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $employee = Employee::with('employeeDocument')->find($id);

        if (File::exists("documents/emp_photos/" . $employee->employeeDocument->emp_photo)) {
            File::delete("documents/emp_photos/" . $employee->employeeDocument->emp_photo);
        }
        if (File::exists("documents/aadhar_cards/" . $employee->employeeDocument->aadhar_card)) {
            File::delete("documents/aadhar_cards/" . $employee->employeeDocument->aadhar_card);
        }
        if (File::exists("documents/pan_cards/" . $employee->employeeDocument->pan_card)) {
            File::delete("documents/pan_cards/" . $employee->employeeDocument->pan_card);
        }
        if (File::exists("documents/passbooks/" . $employee->employeeDocument->passbook)) {
            File::delete("documents/passbooks/" . $employee->employeeDocument->passbook);
        }
        if (File::exists("documents/police_verifications/" . $employee->employeeDocument->police_verification)) {
            File::delete("documents/police_verifications/" . $employee->employeeDocument->police_verification);
        }
        $employee->delete();
        return back()->with('success','Registered Employee Deleted Successfully.');
    }
}
