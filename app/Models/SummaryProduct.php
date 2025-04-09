<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'summary_id',
        'po_id',
        'service_code_id',
        'service_code',
        'sum_date',
        'pg_no',
        'job_description',
        'price',
        'uom',
        'length',
        'width',
        'height',
        'nos',
        'total_qty'
    ];



    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    public function companyServiceCode()
    {
        return $this->belongsTo(CompanyServiceCode::class, 'service_code_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id');
    }

}
