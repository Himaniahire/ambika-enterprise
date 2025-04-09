<?php

namespace App\Http\Controllers;

use App\Models\EmployeeCategory;
use App\Models\EmployeePost;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class EmployeePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $employeePost = EmployeePost::with('getEmployeeCategory')->select('employee_posts.*');

            return DataTables::of($employeePost)
                ->addIndexColumn() // Adds the Sr. No. column
                ->addColumn('employee_category', function($row) {
                    return $row->getEmployeeCategory->emp_category;
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('employee_posts.edit', $row->id);
                    $deleteUrl = route('employee_posts.destroy', $row->id);
                    $csrfToken = csrf_token();

                    return '
                        <ul class="list-unstyled hstack gap-1 mb-0">
                            <li>
                                <a class="btn btn-sm btn-soft-danger" href="' . $editUrl . '"><i data-feather="edit"></i></a>
                            </li>
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="' . $csrfToken . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" style="border: none; background: transparent; padding: 0px" onclick="return confirm(\'Are you sure you want to delete this item?\');">
                                    <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                                </button>
                            </form>
                        </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.employee.employee_posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeeCategory = EmployeeCategory::get();
        return view('admin.employee.employee_posts.add',compact('employeeCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_category_id' => 'required',
            'emp_post' => 'required',
        ]);

        $input = $request->all();

        EmployeePost::create($input);

        return redirect('admin/employee/employee_posts')->with('success','Employee Post Added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeePost $employeePost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employeePost = EmployeePost::with('getEmployeeCategory')->where('id',$id)->first();
        $employeeCategory = EmployeeCategory::get();
        return view('admin.employee.employee_posts.edit',compact('employeePost','employeeCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employeePost = EmployeePost::find($id);
        $request->validate([
            'emp_category_id' => 'required',
            'emp_post' => 'required'
        ]);

        $input = $request->all();

        $employeePost->update($input);

        return redirect('admin/employee/employee_posts')->with('success','Employee Post Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employeePost = EmployeePost::find($id);
        $employeePost->delete();
        return back()->with('success','Employee Post Deleted Successfully.');
    }
}
