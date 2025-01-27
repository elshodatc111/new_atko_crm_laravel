<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCentar extends Model
{
    use HasFactory;
    protected $fillable = [
        "filial_id",
        "tkun",
        "tashrif",
        "tulov"
    ];
}
