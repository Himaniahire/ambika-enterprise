<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'emp_id',
        'status',
        'attendance_date',
        'over_time',
        'is_paid'
    ];

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }

    public function getEmployee() {
        return $this->belongsTo(Employee::class,'emp_id','id');
    }

}
