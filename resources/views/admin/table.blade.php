                 @php
                    $totalWithTax = 0;
                    $totalWithoutTax = 0;
                    $pendingWithTax = 0;
                    $pendingWithoutTax = 0;
                @endphp
                <table id="myTable" style="font-size: 14px;border: 1px solid #ddd;" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Company Name</th>
                            <th>Total Performa With Tax</th>
                            <th>Total Performa Without Tax</th>
                            <th>Total Invoice With Tax</th>
                            <th>Total Invoice Without Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($data as $row)
                            <tr>
                                <td>{{ $row['sr_no'] }}</td>
                                <td>{{ $row['company_name'] }}</td>
                                <td>{{ $row['total_with_tax'] }}</td>
                                <td>{{ $row['total_without_tax'] }}</td>
                                <td>{{ $row['pending_with_tax'] }}</td>
                                <td>{{ $row['pending_without_tax'] }}</td>
                            </tr>
                            @php
                                $totalWithTax += floatval(str_replace(',', '', $row['total_with_tax']));
                                $totalWithoutTax += floatval(str_replace(',', '', $row['total_without_tax']));
                                $pendingWithTax += floatval(str_replace(',', '', $row['pending_with_tax']));
                                $pendingWithoutTax += floatval(str_replace(',', '', $row['pending_without_tax']));
                            @endphp
                        @endforeach

                        <tr>
                            <th></th>
                            <th>Grand Total:</th>
                            <th>{{ number_format($totalWithTax, 2) }}</th>
                            <th>{{ number_format($totalWithoutTax, 2) }}</th>
                            <th>{{ number_format($pendingWithTax, 2) }}</th>
                            <th>{{ number_format($pendingWithoutTax, 2) }}</th>
                        </tr>
                    </tbody>
                </table>
