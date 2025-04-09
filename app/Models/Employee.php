<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_code',
        'emp_post_id',
        'date_of_joining',
        'uan_no',
        'first_name',
        'last_name',
        'father_name',
        'date_of_birth',
        'address',
        'city',
        'state',
        'postal_code',
        'phone_no',
        'status',
        'adhar_no',
        'pan_no',
        'bank_name',
        'branch',
        'ifsc_code',
        'account_no',
        'company_id',
        'income_type',
        'income',
        'advance',
        'emp_leave',
        'emp_type',
        'days',
        'leave_date'
    ];

    public static function boot()
    {
        parent::boot();

        // Generate emp_code before saving
        static::creating(function ($employee) {
            // Get the last employee based on the emp_code
            $lastEmployee = self::orderBy('emp_code', 'desc')->first();

            // If there's no previous employee, start from 990001
            if (!$lastEmployee) {
                $employee->emp_code = '990001';
            } else {
                // Extract the numeric part of the last emp_code
                $lastEmpCodeNumber = (int)$lastEmployee->emp_code;

                // Increment it by 1
                $newEmpCodeNumber = $lastEmpCodeNumber + 1;

                // Pad the new emp_code to maintain six digits
                $employee->emp_code = (string)$newEmpCodeNumber;
            }
        });
    }

    public function employeeDocument(){
        return $this->belongsTo(EmployeeDocument::class, 'id', 'emp_id');
    }

    public function getEmployeePost() {
        return $this->belongsTo(EmployeePost::class,'emp_post_id','id');
    }

    public function getCompany() {
        return $this->belongsTo(RegisterCompany::class,'company_id','id');
    }
}
