<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyServiceCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'order_no',
        'service_code',
        'job_description',
        'uom',
        'price'
    ];
    
    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }
    
    
    public function summaryProducts()
    {
        return $this->hasMany(SummaryProduct::class, 'service_code_id', 'id');
    }
}
