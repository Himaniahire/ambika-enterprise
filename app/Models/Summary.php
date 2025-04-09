<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'gst_id',
        'po_no_id',
        'category_of_service_id',
        'work_contract_order_no',
        'jmr_no',
        'capex_no',
        'sum_no',
        'summ_date',
        'performa_no',
        'performa_date',
        'invoice_no',
        'invoice_date',
        'com_unit',
        'plant',
        'department',
        'document',
        'work_period',
        'gst_type',
        'tax',
        'total',
        'price_total',
        'gst_amount',
        'performa_status',
        'invoice_status'
    ];

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }

    public function summaryProducts() {
        return $this->hasMany(SummaryProduct::class,'summary_id','id')->orderBy('pg_no','asc');
    }

    public function summaryProduct()
    {
        return $this->hasMany(SummaryProduct::class, 'summary_id', 'id'); // Adjust field names if necessary
    }

    public function companyServiceCode()
    {
        return $this->belongsTo(CompanyServiceCode::class, 'company_id', 'company_id');
    }

    public function companyServiceCodes()
    {
        return $this->hasOne(CompanyServiceCode::class, 'company_id', 'company_id');
    }

    public function getCategoryOfService() {
        return $this->belongsTo(CategoryOfService::class,'category_of_service_id','id');
    }
    public function getPO() {
        return $this->belongsTo(PurchaseOrder::class,'po_no_id','id');
    }

    public function getGST() {
        return $this->belongsTo(GstNumber::class,'gst_id','id');
    }

    public function Completeinvoice() {
        return $this->belongsTo(CompleteInvoice::class,'invoice_id','id');
    }
}
