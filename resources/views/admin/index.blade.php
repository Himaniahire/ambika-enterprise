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
                                <div class="small fw-bold text-info mb-1" style="font-size:20px;">Pending Performa</div>
                                <div class="h2">{{ $Pendingperforma }}</div>
                            </div>
                            <div class="ms-2"><i class=" fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example Charts for Dashboard Demo-->
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Monthly Revenue
                        <div class="dropdown no-caret">
                            {{-- <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                <a class="dropdown-item" href="#!">This Month</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!">Custom Range</a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar"><canvas id="myBarChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @php
                    $totalWithTax = 0;
                    $totalWithoutTax = 0;
                    $pendingWithTax = 0;
                    $pendingWithoutTax = 0;
                @endphp
                <a href="{{ route('export.excel') }}" class="btn btn-primary">Excel</a>
                <a href="{{ route('export.pdf') }}" class="btn btn-primary">PDF</a>
                @include('admin.table')
            </div>
        </div>
    </div>
</main>

@endsection


@section('footer-scripts')


@endsection
