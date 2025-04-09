@extends('admin.layouts.layout')
@section('content')
<style>
    .dataTables_processing {
            display: none !important;
        }
</style>
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Purchase Orders List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('purchase_order.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Purchase Orders
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
                    <table id="poTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Total</th>
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
            $('#poTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('purchase_order.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'po_no', name: 'po_no' },
                    { data: 'po_date', name: 'po_date' },
                    { data: 'total', name: 'total' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                drawCallback: function(settings) {
                    feather.replace(); // Re-initialize Feather icons
                },
                order: [[1, 'asc']] // Default ordering if needed
            });
        });

    </script>
@endsection
