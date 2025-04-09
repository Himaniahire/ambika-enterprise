<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAdvanceSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'advance_date',
        'advance_amount',
        'note'
    ];

    public function getEmployee() {
        return $this->belongsTo(Employee::class,'emp_id','id');
    }
}
