<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_category_id',
        'emp_post',

    ];

    public function getEmployeeCategory() {
        return $this->belongsTo(EmployeeCategory::class,'emp_category_id','id');
    }

}
