<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GstNumber extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'gstnumber'];

    public function Getcompany()
    {
        return $this->belongsTo(RegisterCompany::class);
    }
}
