<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Davomat extends Model{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'guruh_id',
        'user_id',
        'dates',
        'status',
        'techer_id',
    ];
}
