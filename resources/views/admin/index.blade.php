@extends('admin.layouts.layout')
@section('content')


<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        @if (Auth::check())
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Welcome , {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!
                            </h1>
                        @else
                            Please log in to access this page.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <!-- Example Colored Cards for Dashboard Demo-->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 1-->
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-1" style="font-size:20px;">Total PO</div>
                                <div class="h2">{{ $po }}</div>
                                <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                </div>
                            </div>
                            <div class="ms-2"><i class=" fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 2-->
                <div class="card border-start-lg border-start-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-secondary mb-1" style="font-size:20px;">Total Performa</div>
                                <div class="h2">{{ $performa }}</div>
                            </div>
                            <div class="ms-2"><i class=" text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 3-->
                <div class="card border-start-lg border-start-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-success mb-1" style="font-size:20px;">Total Invoice</div>
                                <div class="h2">{{ $invoice }}</div>
                            </div>
                            <div class="ms-2"><i class=" fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 4-->
                <div class="card border-start-lg border-start-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-info mb-1" style="font-size:20px;">Complete Invoice</div>
                                <div class="h2">{{ $CompleteInvoice }}</div>
                            </div>
                            <div class="ms-2"><i class=" fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
