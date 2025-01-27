<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MavjudIshHaqi extends Model{
    use HasFactory;
    
    protected $fillable = [
        'filial_id',
        'naqt',
        'plastik',
    ];
}
