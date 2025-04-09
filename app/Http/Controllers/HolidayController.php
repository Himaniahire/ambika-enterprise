<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $holiday = Holiday::select('id', 'holiday_date', 'holiday');

            return DataTables::of($holiday)
                ->addIndexColumn() // Adds the Sr. No. column
                ->editColumn('holiday_date', function($row) {
                    return Carbon::parse($row->holiday_date)->format('d-m-Y');
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('employee_holidays.edit', $row->id);
                    $deleteUrl = route('employee_holidays.destroy', $row->id);
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

        return view('admin.employee.employee_holidays.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.employee_holidays.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required',
            'holiday' => 'required',
        ]);

        $input = $request->all();

        Holiday::create($input);

        return redirect('admin/employee/employee_holidays')->with('success','Holiday Added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $holiday = Holiday::where('id',$id)->first();
        return view('admin.employee.employee_holidays.edit',compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $holiday = Holiday::find($id);
        $request->validate([
            'holiday_date' => 'required',
            'holiday' => 'required',
        ]);

        $input = $request->all();

        $holiday->update($input);

        return redirect('admin/employee/employee_holidays')->with('success','Holiday Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $holiday = Holiday::find($id);
        $holiday->delete();
        return back()->with('success','Holiday Deleted Successfully.');
    }
}
