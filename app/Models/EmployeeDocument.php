<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'aadhar_card',
        'pan_card',
        'passbook',
        'emp_photo',
        'police_verification'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
