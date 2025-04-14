<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplacenceDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'complacence_id',
        'document',
        'document_name',
    ];
    public function complacence()
    {
        return $this->belongsTo(Complacence::class);
    }
}
