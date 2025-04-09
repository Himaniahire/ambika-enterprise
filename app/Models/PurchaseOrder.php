<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'po_date',
        'po_no',
        'com_unit',
        'plant',
        'department',
        'contact_name',
        'contact_num',
        'document',
        'total'
    ];

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }

    public function getProducts() {
        return $this->belongsToMany(PurchaseOrderProduct::class, 'purchase_order_products', 'po_id', 'id');
    }

    public function performaProduct()
    {
        return $this->hasOne(PerformaProduct::class, 'po_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'po_no', 'id');
    }

    public function purchaseOrderProducts()
    {
        return $this->hasMany(PurchaseOrderProduct::class, 'po_id');
    }

    public function companyServiceCode()
    {
        return $this->belongsTo(CompanyServiceCode::class, 'company_id', 'company_id');
    }

}
