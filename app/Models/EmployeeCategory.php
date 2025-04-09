<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_category',

    ];

    public function getCategory()
    {
        return $this->belongsTo(EmployeeCategory::class, 'emp_category_id');
    }

}
