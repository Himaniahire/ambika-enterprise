<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complacence extends Model
{
    use HasFactory;

    protected $fillable = ['company_id'];

    public function documents()
    {
        return $this->hasMany(ComplacenceDocument::class, 'complacence_id');
    }

    public function company()
    {
        return $this->belongsTo(RegisterCompany::class);
    }
}
