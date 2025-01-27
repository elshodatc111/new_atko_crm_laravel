<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eslatma extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'type',
        'user_guruh_id',
        'text',
        'status',
        'admin_id',
    ];
}
