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
                                User List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('user.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New User
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
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
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
            ajax: {
                url: "{{ route('user.index') }}",
                type: "GET",
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'full_name', name: 'full_name' },
                { data: 'email', name: 'email' },
                { data: 'username', name: 'username' },
                { data: 'role_name', name: 'role_name' },
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
