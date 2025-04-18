@extends('admin.layouts.layout')
@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Complacence List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('complacences.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Complacence
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Document Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Document Count</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </main>


@endsection
 @section('footer-script')

 <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("complacences.index") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'company_name', name: 'company.companyname' },
                { data: 'documents_count', name: 'documents_count' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            drawCallback: function(settings) {
                feather.replace(); // Re-initialize Feather icons
            },
            order: [[1, 'asc']]
        });
    });
 </script>

 @endsection
