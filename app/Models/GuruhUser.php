<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruhUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'guruh_id',
        'status',
        'commit_start',
        'admin_id_start',
        'commit_end',
        'admin_id_end',
    ];
}
