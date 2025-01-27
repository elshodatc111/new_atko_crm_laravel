<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Events\TugilganKun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TkunController extends Controller{
    public function index(){
        $today = Carbon::today();
        $Tkunlar = User::whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->get();
        $Users = array();
        $i = 0;
        foreach($Tkunlar as $key => $item){
            TugilganKun::dispatch($item->id);
            $i++;
        }
        return response()->json([
            'status'=>true,
            'messege'=>"Tug'ilgan kun tabrigi yuborildi.",
            'count' => $i
        ],200);
    }
}
