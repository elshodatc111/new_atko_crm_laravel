<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model{
    use HasFactory;
    protected $fillable = [
        'cours_id',
        'Savol',
        'TJavob',
        'NJavob1',
        'NJavob2',
        'NJavob3',
    ];
}
