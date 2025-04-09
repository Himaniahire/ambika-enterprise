<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'tds',
        'retention',
        'payment_receive_date',
        'payment',
        'penalty'
    ];
    
     public function getSumarry() {
        return $this->belongsTo(Summary::class,'invoice_id','id');
    }
}
