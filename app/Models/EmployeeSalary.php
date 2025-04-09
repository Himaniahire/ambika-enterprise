<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'com_id',
        'emp_id',
        'salary_month',
        'total_present',
        'total_leave',
        'total_ot',
        'deduct_advance',
        'salary',
        'additional_amount',
        'note',
    ];

    public function getEmployee() {
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
