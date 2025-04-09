@extends('admin.layouts.layout')
@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add Category Of Service
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('category_of_service.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Category Of Service List
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
                    <div class="card-header">Category Of Service Details</div>
                    <div class="card-body">
                        <form action="{{ route('category_of_service.store') }}" method="POST">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Category Of Service <span class="text-danger">*</span></label>
                                    <input id="productname" name="category_of_service" type="text" class="form-control" value="" placeholder="Category Of Service">
                                    @if ($errors->has('category_of_service'))
                                        <div class="text-danger">{{ $errors->first('category_of_service') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">SAC Code </label>
                                    <input id="productname" name="sac_code" type="text" class="form-control" value="" placeholder="SAC Code">
                                    @if ($errors->has('sac_code'))
                                        <div class="text-danger">{{ $errors->first('sac_code') }}</div>
                                    @endif
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Category Of Service</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
