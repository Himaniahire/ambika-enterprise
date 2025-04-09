<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;

    protected $table = 'role_has_permissions'; // Assuming this is your table name

    protected $fillable = [
        'user_id',
        'role_id',
        'permission_id',
    ];
}
