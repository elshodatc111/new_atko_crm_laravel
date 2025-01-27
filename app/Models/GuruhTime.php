<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruhTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'guruh_id',
        'room_id',
        'dates',
        'times',
    ];
}
