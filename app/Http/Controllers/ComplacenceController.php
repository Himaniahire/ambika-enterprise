<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterCompany;
use App\Models\Complacence;
use App\Models\ComplacenceDocument;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ComplacenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Complacence::with('company')->withCount('documents');

        return DataTables::of($data)
            ->addColumn('company_name', function ($row) {
                return $row->company->companyname ?? '-';
            })
            ->addColumn('documents_count', function ($row) {
                return $row->documents_count ?? 0;
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('complacences.show', $row->id);
                $editUrl = route('complacences.edit', $row->id);
                $deleteUrl = route('complacences.destroy', $row->id);

                return '
                    <ul class="list-unstyled hstack gap-1 mb-0">
                        <li>
                            <a class="btn btn-sm btn-soft-primary" href="' . $showUrl . '">
                                <i data-feather="eye"></i>
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-sm btn-soft-primary" href="' . $editUrl . '">
                                <i data-feather="edit"></i>
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm(\'Are you sure you want to delete this?\');">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $companies = RegisterCompany::where('com_status', 1)->get();
    return view('admin.complacence.index', compact('companies'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = RegisterCompany::where('com_status',1)->get();
        return view('admin.complacence.add', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $complacence = Complacence::create([
            'company_id' => $request->company_id,
        ]);

        $complacence_id = $complacence->id;

        if ($request->has('document_name')) {
            foreach ($request->document_name as $index => $docName) {
                $file = $request->file('document')[$index] ?? null;

                if ($file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('complacence');

                    // Ensure the directory exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    ComplacenceDocument::create([
                        'complacence_id' => $complacence_id,
                        'document_name'  => $docName,
                        'document'       => 'complacence/' . $filename, // Save relative path
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Complacence and documents added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Complacence = Complacence::find($id);
        return view('admin.complacence.show', compact('Complacence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companies = RegisterCompany::where('com_status',1)->get();
        $Complacence = Complacence::with('company', 'documents')->find($id);
        return view('admin.complacence.edit', compact('Complacence', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'company_id' => 'required|exists:register_companies,id',
        'document_name.*' => 'nullable|string|max:255',
        'document.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $complacence = Complacence::with('documents')->findOrFail($id);

    $complacence->company_id = $request->input('company_id');
    $complacence->save();

    $existingDocuments = $complacence->documents;

    $documentNames = $request->input('document_name', []);
    $uploadedFiles = $request->file('document', []);

    $destinationPath = public_path('complacence');

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    foreach ($documentNames as $index => $name) {
        if (isset($existingDocuments[$index])) {
            $docModel = $existingDocuments[$index];
            $docModel->document_name = $name;

            if (isset($uploadedFiles[$index])) {
                // Delete old file
                $oldFilePath = public_path($docModel->document);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Save new file
                $filename = time() . '_' . $uploadedFiles[$index]->getClientOriginalName();
                $uploadedFiles[$index]->move($destinationPath, $filename);

                $docModel->document = 'complacence/' . $filename;
            }

            $docModel->save();
        } else {
            $path = null;

            if (isset($uploadedFiles[$index])) {
                $filename = time() . '_' . $uploadedFiles[$index]->getClientOriginalName();
                $uploadedFiles[$index]->move($destinationPath, $filename);
                $path = 'documents/' . $filename;
            }

            $complacence->documents()->create([
                'document_name' => $name,
                'document' => $path,
            ]);
        }
    }

    return redirect()->route('complacences.index')->with('success', 'Complacence updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $complacence = Complacence::with('documents')->findOrFail($id);

        // Delete all related document files from storage
        foreach ($complacence->documents as $document) {
            if ($document->document && Storage::exists('public/' . $document->document)) {
                Storage::delete('public/' . $document->document);
            }
        }

        // Delete related document records from database
        $complacence->documents()->delete();

        // Delete the complacence record
        $complacence->delete();

        return redirect()->route('complacences.index')->with('success', 'Complacence and its documents deleted successfully.');
    }

    public function destroyDoc($id)
    {
        $document = ComplacenceDocument::findOrFail($id);

        // Optionally delete the file from storage
        if (file_exists(public_path($document->document))) {
            unlink(public_path($document->document));
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}
