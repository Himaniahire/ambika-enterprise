<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'po_no_id',
        'unit',
        'jmr_no',
        'work_contract_order_no',
        'plant',
        'department',
        'category_of_service_id',
        'invoice_no',
        'performa_no',
        'performa_date',
        'document',
        'invoice_date',
        'work_period',
        'tax',
        'total',
        'gst_amount',
        'status'
    ];

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }
    public function getCategoryOfService() {
        return $this->belongsTo(CategoryOfService::class,'category_of_service_id','id');
    }
    public function getPoId() {
        return $this->belongsTo(PurchaseOrderProduct::class,'po_no_id','po_id');
    }
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_no_id', 'id');
    }

    public function completeInvoice()
    {
        return $this->hasOne(CompleteInvoice::class, 'id', 'invoice_id');
    }

}
