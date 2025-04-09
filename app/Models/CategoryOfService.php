<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOfService extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_of_service',
        'sac_code'
    ];
}
