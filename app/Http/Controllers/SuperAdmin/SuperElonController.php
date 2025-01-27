<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperElonController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function techer(){
        return view('SuperAdmin.elonlar.techer');
    }
    public function student(){
        return view('SuperAdmin.elonlar.student');
    }
}
