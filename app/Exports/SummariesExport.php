<?php

namespace App\Exports;

use App\Models\Summary;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummariesExport implements FromView, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('admin.accountant.summary.excel', $this->data);
    }

    public function title(): string
    {
        return 'SummarySheet';
    }
}
