<?php

namespace App\Exports;

use App\Models\RegisterCompany;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TableExport implements FromCollection, WithHeadings,  WithColumnWidths
{
    public function collection()
    {
        $companies = RegisterCompany::whereHas('summaries', function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel');
        })->with(['summaries' => function ($query) {
            $query->where('invoice_status', '!=', 'Cancel')
                  ->where('performa_status', '!=', 'Cancel')
                  ->select('company_id', 'price_total', 'gst_amount', 'invoice_no', 'performa_no');
        }])->get();


        $data = [];
        $totalWithTax = $totalWithoutTax = $pendingWithTax = $pendingWithoutTax = 0;

        foreach ($companies as $index => $company) {
            $totalWithTaxRow = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
                ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');

            $totalWithoutTaxRow = $company->summaries->whereNotNull('performa_no')->where('invoice_status', '!=', 'Cancel')
                ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            $pendingWithTaxRow = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
                ->where('performa_status', '!=', 'Cancel')->sum('gst_amount');

            $pendingWithoutTaxRow = $company->summaries->whereNotNull('invoice_no')->where('invoice_status', '!=', 'Cancel')
                ->where('performa_status', '!=', 'Cancel')->sum('price_total');

            // Add to grand totals
            $totalWithTax += $totalWithTaxRow;
            $totalWithoutTax += $totalWithoutTaxRow;
            $pendingWithTax += $pendingWithTaxRow;
            $pendingWithoutTax += $pendingWithoutTaxRow;

            $data[] = [
                'sr_no' => $index + 1,
                'company_name' => $company->companyname,
                'total_with_tax' => number_format($totalWithTaxRow, 2),
                'total_without_tax' => number_format($totalWithoutTaxRow, 2),
                'pending_with_tax' => number_format($pendingWithTaxRow, 2),
                'pending_without_tax' => number_format($pendingWithoutTaxRow, 2),
            ];
        }


        // Add Grand Total row
        $data[] = [
            'sr_no' => '',
            'company_name' => 'Grand Total:',
            'total_with_tax' => number_format($totalWithTax, 2),
            'total_without_tax' => number_format($totalWithoutTax, 2),
            'pending_with_tax' => number_format($pendingWithTax, 2),
            'pending_without_tax' => number_format($pendingWithoutTax, 2),
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Company Name',
            'Total Performa With Tax',
            'Total Performa Without Tax',
            'Total Invoice With Tax',
            'Total Invoice Without Tax',
        ];
    }

    // Set the widths for the columns
    public function columnWidths(): array
    {
        return [
            'A' => 10,   // Sr. No.
            'B' => 50,   // Company Name
            'C' => 30,   // Total With Tax Amount
            'D' => 30,   // Total Without Tax Amount
            'E' => 30,   // Pending Total With Tax Amount
            'F' => 50,   // Pending Total Without Tax Amount
        ];
    }

}
