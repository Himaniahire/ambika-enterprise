@extends('admin.layouts.layout')
@section('content')

<style>
    @media (min-width: 1500px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1661px;
    }
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
                                Employee Advance Report
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

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
                        <div class="card-header">Employee Advance Report</div>
                        <div class="card-body">
                            <form action="" method="" id="emp-report-form" class="mb-3">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Employee Name</label>
                                        <select class="form-control select2" id="emp_id" name="emp_id" required>
                                            <option value="">Select Employee Name</option>
                                            @foreach ($employee as $item)
                                                <option value="{{ $item->id }}">{{ $item->first_name }} {{ $item->father_name }} {{ $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                            <table id="empAdvance" class="mt-3"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Employee Name",
            allowClear: true
        });
    });
    // $(document).ready(function() {
    //     var months = [
    //         { value: '01', name: 'January' },
    //         { value: '02', name: 'February' },
    //         { value: '03', name: 'March' },
    //         { value: '04', name: 'April' },
    //         { value: '05', name: 'May' },
    //         { value: '06', name: 'June' },
    //         { value: '07', name: 'July' },
    //         { value: '08', name: 'August' },
    //         { value: '09', name: 'September' },
    //         { value: '10', name: 'October' },
    //         { value: '11', name: 'November' },
    //         { value: '12', name: 'December' }
    //     ];

    //     $.each(months, function(index, month) {
    //         $('#monthDropdown').append($('<option>', {
    //             value: month.value,
    //             text: month.name
    //         }));
    //     });

    //     var startYear = 2023;
    //     var endYear = new Date().getFullYear();
    //     for (var year = startYear; year <= endYear; year++) {
    //         $('#yearDropdown').append($('<option>', {
    //             value: year,
    //             text: year
    //         }));
    //     }
    // });

    $(document).ready(function () {
        $('#emp-report-form').on('submit', function(e) {
            e.preventDefault();

            var empId = $('#emp_id').val();
            var employeeName = $('#emp_id option:selected').text();

            var dataTable = $('#empAdvance').DataTable({
                processing: true,
                serverSide: true,
                destroy: true, // Reinitialize the table when new data is fetched
                ajax: {
                    url: '{{ route('reports.fetch_emp_advance_report') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        emp_id: empId
                    }
                },
                columns: [
                    { data: 'advance_date', name: 'advance_date', title: 'Advance Date' },
                    { data: 'advance_amount', name: 'advance_amount', title: 'Total Advance Amount' },
                    { data: 'salary_month', name: 'salary_month', title: 'Salary Month' },
                    { data: 'deduct_advance', name: 'deduct_advance', title: 'Deduct Amount' },
                    { data: 'advance', name: 'advance', visible: false } // Hidden column
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Employee Advance Salaries - ' + employeeName,
                        customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    var remainAdvance = calculateRemainAdvance(dataTable);
                                    var lastRow = $('row', sheet).last();
                                    var lastRowIndex = parseInt(lastRow.attr('r')) + 1;

                                    var newRow = `
                                        <row r="${lastRowIndex}">
                                            <c t="inlineStr" r="A${lastRowIndex}">
                                                <is><t>Remaining Advance</t></is>
                                            </c>
                                            <c t="n" r="F${lastRowIndex}">
                                                <v>${remainAdvance}</v>
                                            </c>

                                        </row>`;
                                    sheet.childNodes[0].childNodes[1].innerHTML += newRow;
                                }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Employee Advance Salaries - ' + employeeName,
                        customize: function(doc) {
                            var remainAdvance = calculateRemainAdvance(dataTable);
                            doc.content.push({
                                text: 'Remaining Advance: ' + remainAdvance ,
                                style: 'subheader',
                                alignment: 'right'
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Employee Advance Salaries - ' + employeeName,
                        customize: function(win) {
                            var remainAdvance = calculateRemainAdvance(dataTable);
                            $(win.document.body).append(`
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Remaining Advance: </strong>${remainAdvance}</td>
                                    </tr>
                                </tfoot>
                            `);
                        }
                    }
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var remainAdvance = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0).toFixed(2);

                    var grandTotalRow = '<tfoot><tr><td colspan="2"></td><td>Remaining Advance:</td><td>' + remainAdvance + '</td></tr></tfoot>';
                    $('#empAdvance tfoot').remove(); // Remove the existing footer if any
                    $('#empAdvance').append(grandTotalRow); // Append the new footer with the grand total
                }
            });

            function calculateRemainAdvance(dataTable) {
                var data = dataTable.rows({ page: 'current' }).data().toArray();
                return data.reduce(function(acc, curr) {
                    return acc + parseFloat(curr.advance);
                }, 0).toFixed(2);
            }
        });
    });







</script>

@endsection
