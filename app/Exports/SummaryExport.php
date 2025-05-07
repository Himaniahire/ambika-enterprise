<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class SummaryExport implements FromView, WithTitle
{
    protected $summaries;
    protected $companyName;
    protected $gstNumber;
    protected $panNumber;
    protected $state;
    protected $comany_id;

    public function __construct($summaries, $companyName, $gstNumber, $panNumber, $state, $comany_id)
    {
        $this->summaries = $summaries;
        $this->companyName = $companyName;
        $this->gstNumber = $gstNumber;
        $this->panNumber = $panNumber;
        $this->state = $state;
        $this->comany_id = $comany_id;
    }

    // Return the Blade view for the Excel export
    public function view(): View
    {
        return view('admin.accountant.reports.masterexcel', [
            'summaries' => $this->summaries,
            'companyName' => $this->companyName,
            'gstNumber' => $this->gstNumber,
            'panNumber' => $this->panNumber,
            'state' => $this->state,
            'comany_id' => $this->comany_id,
        ]);
    }

    // Set the title for the Excel sheet
    public function title(): string
    {
        return 'SummarySheet';
    }
}


