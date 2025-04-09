<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaProduct extends Model
{
    use HasFactory;
    protected $table = 'performa_products';

    protected $fillable = [
        'performa_id',
        'po_id',
        'product_name',
        'description',
        'uom',
        'rate',
        'qty',
        'total_amount',
    ];

    public function getPoId() {
        return $this->belongsTo(PurchaseOrderProduct::class,'po_id','po_id');
    }
    public function getProduct() {
        return $this->belongsTo(PurchaseOrderProduct::class,'product_name','id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id');
    }
}
