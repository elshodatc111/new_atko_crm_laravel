<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model{
    use HasFactory;
    protected $fillable = [
        'cours_name',
        'sort_numbr',
        'lessen_name',
        'video_url',
    ];
}
 