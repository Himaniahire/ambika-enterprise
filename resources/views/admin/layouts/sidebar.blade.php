<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu" style="padding: 0px 8px 0px 8px;">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="{{route('adminhome')}}">
                    <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/menu.png') }}"
                            alt="dashbord" style="width: 23px;"></div>
                    Dashboards
                </a>
                <div class="sidenav-menu-heading">Accountant</div>
                @if(Auth::user()->permission->contains('name', 'company_register'))
                    <a class="nav-link" href="{{ route('register_company.index') }}">
                        <div class="nav-link-icon">
                            <img src="{{ asset('admin_assets/sidebar_icon/office-building.png') }}" alt="dashbord" style="width: 23px;">
                        </div>
                        Company Registration
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'category_of_service'))
                    <a class="nav-link" href="{{ route('category_of_service.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/list.png') }}"
                                alt="dashbord" style="width: 23px;"></div>
                        Category Of Service
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'purchase_order'))
                    <a class="nav-link collapsed" href="{{ route('purchase_order.index') }}" >
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/order-delivery.png') }}" style="width: 23px;"></div>
                        Purchase Order
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'summary'))
                    <a class="nav-link collapsed" href="{{ route('summary.index') }}" >
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/summary-check.png') }}" style="width: 23px;"></div>
                        Summary
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'performa'))
                    <a class="nav-link collapsed" href="{{ route('performa.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/efficacy.png') }}" style="width: 23px;"></div>
                        Performa
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'invoice'))
                    <a class="nav-link collapsed" href="{{ route('invoice.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/invoice.png') }}" style="width: 23px;"></div>
                        Invoice
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'acc_reports'))
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/report.png') }}"
                                alt="dashbord" style="width: 23px;"></div>
                        Report
                        <div class="sidenav-collapse-arrow"><i data-feather="chevron-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseReport" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('reports.master_report') }}">Master Report</a>
                            <a class="nav-link" href="{{ route('reports.company_po_report') }}">Company/PO/Service Code
                                Report</a>
                            <a class="nav-link" href="{{ route('reports.company_inv_report') }}">Pending Performa
                                Report</a>
                            <a class="nav-link" href="{{ route('reports.invoice_report') }}">Invoice Payment Receive
                                Report</a>
                            {{-- <!--<a class="nav-link" href="{{ route('reports.final_invoice_report') }}">Final Invoice Report</a>--> --}}
                        </nav>
                    </div>
                @endif
                @if(Auth::user()->permission->contains('name', 'activity_log'))
                    <a class="nav-link" href="{{ route('activity_log.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/menu.png') }}"
                                alt="dashbord" style="width: 23px;"></div>
                        Activity Log
                    </a>
                @endif

                <div class="sidenav-menu-heading">Employee</div>
                @if(Auth::user()->permission->contains('name', 'employee_holidays'))
                    <a class="nav-link" href="{{ route('employee_holidays.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/holiday.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Holidays
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_categories'))
                    <a class="nav-link" href="{{ route('employee_categories.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/list.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Categories
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_posts'))
                    <a class="nav-link" href="{{ route('employee_posts.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/business.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Post
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_advance_salary'))
                    <a class="nav-link" href="{{ route('employee_advance_salary.index') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/salary.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Advance Salary
                    </a>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_details'))
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#collapseEmployee" aria-expanded="false" aria-controls="collapseEmployee">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/employee.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Employees
                        <div class="sidenav-collapse-arrow"><i data-feather="chevron-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEmployee" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('employee_details.create') }}">Register Employee</a>
                            <a class="nav-link" href="{{ route('employee_details.index') }}">Office Employee List</a>
                            <a class="nav-link" href="{{ route('employee_details.site') }}">Site Employee List</a>
                        </nav>
                    </div>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_attendance'))
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#collapseEmployeeAttendance" aria-expanded="false"
                        aria-controls="collapseEmployeeAttendance">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/time.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Employee Attendance
                        <div class="sidenav-collapse-arrow"><i data-feather="chevron-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEmployeeAttendance" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            @if(Auth::user()->permission->contains('name', 'employee_company_transfer'))
                                <a class="nav-link" href="{{ route('employee_company_transfer.index') }}">Company
                                    Transfer</a>
                            @endif
                            <a class="nav-link" href="{{ route('employee_attendance.create') }}">Add/Edit
                                Attendance</a>
                            {{-- <a class="nav-link" href="{{ route('employee_attendance.index') }}">Employee Attendance
                                List</a>
                            <a class="nav-link" href="{{ route('employee_attendance.attendance_edit') }}">Edit Employee
                                Attendance</a> --}}
                        </nav>
                    </div>
                @endif
                @if(Auth::user()->permission->contains('name', 'employee_salary'))
                    <a class="nav-link" href="{{ route('employee_salary.create') }}">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/salary-1.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Generate Salary
                    </a>
                    {{-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#collapseEmployeeSalary" aria-expanded="false"
                        aria-controls="collapseEmployeeSalary">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/salary-1.png') }}"
                                alt="dashbord" style="width: 30px;"></div>
                        Employee Salary
                        <div class="sidenav-collapse-arrow"><i data-feather="chevron-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEmployeeSalary" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('employee_salary.create') }}">Create Employee Salary</a>
                        </nav>
                    </div> --}}
                @endif
                @if(Auth::user()->permission->contains('name', 'emp_reports'))
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#collapseempReport" aria-expanded="false" aria-controls="collapseempReport">
                        <div class="nav-link-icon"><img src="{{ asset('admin_assets/sidebar_icon/report.png') }}"
                                alt="dashbord" style="width: 23px;"></div>
                        Report
                        <div class="sidenav-collapse-arrow"><i data-feather="chevron-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseempReport" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('reports.attendance_report') }}">Attendance Report</a>
                            <a class="nav-link" href="{{ route('reports.salary_report') }}">Salary Report</a>
                            <a class="nav-link" href="{{ route('reports.emp_advance_report') }}">Employee Advance
                                Report</a>
                            {{-- <a class="nav-link" href="{{ route('reports.emp_salary_report') }}">Employee Salary
                                Report</a> --}}
                            <a class="nav-link" href="{{ route('reports.emp_join_leave_report') }}">Employee Join/Leave
                                Report</a>
                        </nav>
                    </div>
                @endif

                <div class="sidenav-menu-heading">User</div>
                @if(Auth::user()->permission->contains('name', 'users'))
                    <a class="nav-link collapsed" href="{{ route('user.index') }}">
                        <div class="nav-link-icon"><img src="{{asset('admin_assets/sidebar_icon/menu.png')}}" alt="dashbord" style="width: 23px;"></div>
                        User Register
                    </a>
                    <a class="nav-link collapsed" href="{{ route('complacences.index') }}">
                        <div class="nav-link-icon"><img src="{{asset('admin_assets/sidebar_icon/menu.png')}}" alt="dashbord" style="width: 23px;"></div>
                        Complacence
                    </a>
                @endif
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                @if (Auth::check())
    <?php
    $roleName = Auth::user()->role->name ?? 'No Role Assigned';
    ?>
    <div class="sidenav-footer-title">{{ ucfirst($roleName) }}</div>
@endif

            </div>
        </div>
    </nav>
</div>

