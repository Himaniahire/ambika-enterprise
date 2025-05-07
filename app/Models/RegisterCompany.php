<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyname',
        'state',
        'inv_no_name',
        'vendor_code',
        'email',
        'address_1',
        'address_2',
        'gstnumber',
        'pannumber',
        'phone',
        'address_3',
        'com_status',
        'lut_no',
        'doa',
        'is_lut'
    ];
    
    public function summaries()
    {
        return $this->hasMany(\App\Models\Summary::class, 'company_id', 'id');
    }


}
