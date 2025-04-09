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
                            Add Register Company
                        </h1>
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
                    <div class="card-header">Register Company Details</div>
                    <div class="card-body">
                        <form action="" method="">
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Company Name</label>
                                    <input id="productname" name="companyname" type="text" class="form-control" value="{{$companies->companyname}}" placeholder="Company Name" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Unit Name</label>
                                    <input id="productname" name="unit_name" type="text" class="form-control" value="{{$companies->unit_name}}" placeholder="Unit Name" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Email</label>
                                        <input id="manufacturername" name="email" type="email" class="form-control"
                                            value="{{$companies->email}}" placeholder="Email" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">GST Number</label>
                                        <input id="productname" name="gstnumber" type="text" class="form-control"
                                            value="{{$companies->gstnumber}}" placeholder="GST Number" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">PAN Number</label>
                                    <input id="productname" name="pannumber" type="text" class="form-control"
                                        value="{{$companies->pannumber}}" placeholder="PAN Number" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Mobile Number</label>
                                        <input id="manufacturername" name="phone" type="text" class="form-control"
                                            value="{{$companies->phone}}" placeholder="Mobile Number" disabled>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturerbrand">Address</label>
                                        <input id="manufacturerbrand" name="address" type="text" class="form-control"
                                            value="{{$companies->address}}" placeholder="Address" disabled>
                                </div>

                                <div class="col-6 col-md-3">
                                    <label for="manufacturerbrand">District</label>
                                    <input id="manufacturerbrand" name="district" type="text" class="form-control"
                                        value="{{$companies->district}}" placeholder="District" disabled>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="manufacturerbrand">State</label>
                                        <input id="manufacturerbrand" name="state" type="text" class="form-control"
                                            value="{{$companies->state}}" placeholder="State" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
