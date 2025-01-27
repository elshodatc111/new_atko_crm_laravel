<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestNatija extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'guruh_id',
        'user_id',
        'savol_count',
        'tugri_count',
        'notugri_count',
        'ball',
    ];
}
