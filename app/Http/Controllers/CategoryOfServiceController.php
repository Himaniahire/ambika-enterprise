<?php

namespace App\Http\Controllers;

use App\Models\CategoryOfService;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class CategoryOfServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CategoryOfService::select(['id', 'category_of_service', 'sac_code'])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('category_of_service.edit', $row->id);
                    $deleteUrl = route('category_of_service.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return '<ul class="list-unstyled hstack gap-1 mb-0">
                                <li>
                                    <a class="btn btn-sm btn-soft-danger" href="'.$editUrl.'"><i data-feather="edit"></i></a>
                                </li>
                                <form action="'.$deleteUrl.'" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                                    '.$csrf.'
                                    '.$method.'
                                    <button type="submit" class="btn btn-sm btn-soft-danger" style="border: none; background: transparent; padding: 0px">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.accountant.category_of_service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accountant.category_of_service.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_of_service' => 'required',
        ]);

        $input = $request->all();

        CategoryOfService::create($input);

        return redirect('admin/accountant/category_of_service')->with('success','Category Of Service Added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryOfService $categoryOfService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoryOfService = CategoryOfService::where('id',$id)->first();
        return view('admin.accountant.category_of_service.edit',compact('categoryOfService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categoryOfService = CategoryOfService::find($id);
        $request->validate([
            'category_of_service' => 'required'
        ]);

        $input = $request->all();

        $categoryOfService->update($input);

        return redirect('admin/accountant/category_of_service')->with('success','Category Of Service Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoryOfService = CategoryOfService::find($id);
        $categoryOfService->delete();
        return back()->with('success','Category Of Service Deleted Successfully.');
    }
}
