<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guruh extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'techer_id',
        'cours_id',
        'room_id',
        'guruh_name',
        'guruh_price',
        'guruh_chegirma',
        'guruh_admin_chegirma',
        'techer_price',
        'techer_bonus',
        'guruh_status',
        'guruh_start',
        'guruh_end',
        'guruh_vaqt',
        'admin_id'
    ];
}
