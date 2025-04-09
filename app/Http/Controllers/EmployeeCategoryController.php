<?php

namespace App\Http\Controllers;

use App\Models\EmployeeCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class EmployeeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $employeeCategory = EmployeeCategory::select('id', 'emp_category');

            return DataTables::of($employeeCategory)
                ->addIndexColumn() // Adds the Sr. No. column
                ->addColumn('action', function($row) {
                    return '
                        <ul class="list-unstyled hstack gap-1 mb-0">
                            <li>
                                <button class="btn btn-sm btn-soft-primary" data-id="' . $row->id . '" data-name="' . $row->emp_category . '" data-bs-toggle="modal" data-bs-target="#editGroupModal">
                                    <i data-feather="edit"></i>
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.employee.employee_categories.index');
    }
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
        $request->validate([
            'emp_category' => 'required|string|max:255|unique:employee_categories,emp_category',
        ]);

        $category = new EmployeeCategory();
        $category->emp_category = $request->emp_category;
        $category->save();

        return response()->json(['success' => 'Category added successfully', 'category' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeCategory $employeeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeCategory $employeeCategory)
    {
        return response()->json($employeeCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeCategory $employeeCategory)
    {
        $request->validate([
            'emp_category' => 'required|string|max:255|unique:employee_categories,emp_category',
        ]);

        $employeeCategory->emp_category = $request->emp_category;
        $employeeCategory->save();

        return response()->json(['success' => 'Category updated successfully', 'category' => $employeeCategory]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeCategory $employeeCategory)
    {
        $employeeCategory->delete();

        return back()->with('success','Category deleted successfully');
    }
}
