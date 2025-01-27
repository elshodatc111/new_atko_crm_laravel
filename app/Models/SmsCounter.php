<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCounter extends Model{
    use HasFactory;
    protected $fillable = [
        "maxsms",
        "counte"
    ];
}
