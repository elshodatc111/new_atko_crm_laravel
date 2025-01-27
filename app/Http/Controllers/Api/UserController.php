<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Room;
use App\Models\GuruhTime;
use App\Models\Guruh;
use App\Models\GuruhUser;
use App\Models\Tulov;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function home(){
        $userGuruhs = GuruhUser::where('guruh_users.user_id', Auth::user()->id)
            ->join('guruhs', 'guruhs.id', '=', 'guruh_users.guruh_id')
            ->where('guruh_users.status', 'true')
            ->select('guruhs.guruh_start', 'guruhs.guruh_end', 'guruhs.guruh_price', 'guruhs.guruh_name', 'guruhs.guruh_chegirma', 'guruhs.created_at', 'guruhs.id')
            ->get();
        $now = date('Y-m-d');
        $Guruhlar = $userGuruhs->map(function ($item) use ($now, &$statistik) {
            $guruh_start = $item->guruh_start;
            $guruh_end = $item->guruh_end;
            $status = 'end';
            if ($guruh_end < $now) {
                $status = 'end';
            } elseif ($guruh_start > $now) {
                $status = 'new';
            } elseif ($guruh_start <= $now && $guruh_end >= $now) {
                $status = 'start';
            }
            return [
                'id' => $item->id,
                'name' => $item->guruh_name,
                'status' => $status,
                'start' => $guruh_start,
                'end' => $guruh_end,
            ];
        });
        return response()->json([
            "status" => true,
            "message" => "Home",
            "group" => $Guruhlar,
        ]);
    }

    public function home_show($id){
        $Guruh = Guruh::find($id);
        $Guruhs = array();
        switch ($Guruh->guruh_vaqt) {
            case '1':
                $Guruhs['guruh_vaqt'] = "08:00-09:30";
                break;
            case '2':
                $Guruhs['guruh_vaqt'] = "09:30-11:00";
                break;
            case '3':
                $Guruhs['guruh_vaqt'] = "11:00-12:30";
                break;
            case 4:
                $Guruhs['guruh_vaqt'] = "12:30-14:00";
                break;
            case '5':
                $Guruhs['guruh_vaqt'] = "14:00-15:30";
                break;
            case '6':
                $Guruhs['guruh_vaqt'] = "15:30-17:00";
                break;
            case '7':
                $Guruhs['guruh_vaqt'] = "17:00-18:30";
                break;
            case '8':
                $Guruhs['guruh_vaqt'] = "18:30-20:00";
                break;
            case '9':
                $Guruhs['guruh_vaqt'] = "20:00-21:30";
                break;
        }
        $Guruhs['guruh_name'] = $Guruh->guruh_name;
        $Guruhs['guruh_price'] = $Guruh->guruh_price;
        $Guruhs['guruh_start'] = $Guruh->guruh_start;
        $Guruhs['guruh_end'] = $Guruh->guruh_end;
        $Guruhs['techer'] = User::find($Guruh->techer_id)->name;
        $Guruhs['test'] = 0;
        $Guruhs['room'] = Room::find($Guruh['room_id'])->room_name;
        $Guruhs['cours_id'] = $Guruh->cours_id;
        $times = array();
        $GuruhTime = GuruhTime::where('guruh_id',$Guruh['id'])->get();
        foreach ($GuruhTime as $key => $value) {
            $times[$key] = $value->dates;
        }
        return response()->json([
            "status" => true,
            "message" => "Home Show",
            "group" => $Guruhs,
            "data" => $times,
        ]);
    }

    public function paymart(){
        $Tulovlar = Tulov::where('user_id',Auth::user()->id)->orderby('id','desc')->get();
        $Tulov = array();
        foreach($Tulovlar as $key=>$item){
            $Tulov[$key]['summa'] = number_format(($item->summa), 0, '.', ' ');
            $Tulov[$key]['type'] = $item->type;
            $Tulov[$key]['created_at'] = $item->created_at;
        } 
        return response()->json([
            "status" => true,
            "message" => "To'lovlar",
            "date" => $Tulov,
        ]);
    }
}
