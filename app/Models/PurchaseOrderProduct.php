<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_id',
        'service_code_id',
        'job_description',
        'hsn_sac_code',
        'uom',
        'qty',
        'price',
        'total_amount'
    ];

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class);
    }

    public function getServiceCode() {
        return $this->belongsTo(CompanyServiceCode::class, 'service_code_id','id');
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class, 'purchase_order_products', 'id', 'po_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }
}
