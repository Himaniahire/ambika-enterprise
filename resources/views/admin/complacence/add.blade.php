@extends('admin.layouts.layout')
@section('content')

<style>
    .error {
        color: red;
        font-size: 0.875em;
    }
</style>
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add User
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('complacences.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to complacences List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content -->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Complacence</div>
                    <div class="card-body">
                        <form action="{{ route('complacences.store') }}" method="POST" id="registrationForm" enctype="multipart/form-data">
                            @csrf
                            @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error')}}
                        </div>
                        @endif
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="company_id">Company name <span class="text-danger">*</span></label>
                                    <select class="form-control company_id  @error('company_id') is-invalid @enderror" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $item)
                                            <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div data-repeater-list="group-a" id="dynamicAddRemove">
                                            <div data-repeater-item class="row mb-2" style="padding: 6px">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->getMessages() as $key => $messages)
                                                                @if (preg_match('/\.\d+$/', $key))
                                                                    @foreach ($messages as $message)
                                                                        <li>{{ $message }}</li>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif


                                                <table class="table" id="jobDescriptionContainer">
                                                    <span id="multi-error-message" class="multi-error"></span>
                                                    <thead>
                                                        <tr>
                                                            <th>Document Name</th>
                                                            <th>Document</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="addMultipleDocument">
                                                        @if(old('document_name'))
                                                            @foreach(old('document_name') as $index => $document_name)
                                                                <tr>
                                                                    <td class="mb-3 col-lg-5"><input type="text" name="document_name[]" class="form-control document_name" value="" placeholder="Document Name" /></td>
                                                                    <td class="mb-3 col-lg-5"><input type="file" style="text-align: center;" name="document[]" class="form-control document"/></td>
                                                                    <td class="mb-3 col-lg-2">
                                                                        @if($index === 0)
                                                                            <input data-repeater-create type="button" id="addDoc" class="form-control btn btn-info addDoc mt-5 mt-lg-0" value="+" />
                                                                        @else
                                                                            <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td class="mb-3 col-lg-5"><input type="text" name="document_name[]" class="form-control document_name" value="" placeholder="Document Name" /></td>
                                                                <td class="mb-3 col-lg-5"><input type="file" style="text-align: center;" name="document[]" class="form-control document"/></td>
                                                                <td class="mb-3 col-lg-2"><input data-repeater-create type="button" id="addDoc" class="form-control btn btn-info addDoc mt-5 mt-lg-0" value="+" /></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="submitBtn" type="submit">Add Complacence</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Add new row
        $(document).on('click', '.addDoc', function () {
            let newRow = `<tr>
                <td class="mb-3 col-lg-5">
                    <input type="text" name="document_name[]" class="form-control document_name" value="" placeholder="Document Name" />
                </td>
                <td class="mb-3 col-lg-5">
                    <input type="file" style="text-align: center;" name="document[]" class="form-control document" />
                </td>
                <td class="mb-3 col-lg-2">
                    <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                </td>
            </tr>`;

            $('.addMultipleDocument').append(newRow);
        });

        // Remove row
        $(document).on('click', '.remove-input-field', function () {
            $(this).closest('tr').remove();
        });
    });
</script>

@endsection
