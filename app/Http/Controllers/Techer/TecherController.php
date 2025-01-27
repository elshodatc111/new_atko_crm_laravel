<?php

namespace App\Http\Controllers\Techer;
use App\Models\Guruh;
use App\Models\Tulov;
use App\Models\User;
use App\Models\TestNatija;
use App\Models\Room;
use App\Models\Davomat;
use App\Models\IshHaqi;
use App\Models\GuruhUser;
use App\Models\GuruhTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TecherController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $Guruhlar = Guruh::where('techer_id',Auth::user()->id)->where('guruh_status','true')->get();
        $Stat = array();
        $start = 0;
        $new = 0;
        $end = 0;
        foreach ($Guruhlar as $key => $value) {
            $guruh_start = $value->guruh_start;
            $now = date('Y-m-d');
            $guruh_end = $value->guruh_end;
            if($guruh_start <= $now AND $guruh_end>= $now){
                $start = $start + 1;
            }elseif($guruh_start>$now){
                $new = $new + 1;
            }else{
                $end = $end +1;
            }
        }
        $Stat['start'] = $start;
        $Stat['new'] = $new;
        $Stat['end'] = $end;
        $DateNow = date("Y-m")."-01 00:00:00";
        $IshHaqiNow = IshHaqi::where('user_id',Auth::user()->id)->where('created_at','>=',$DateNow)->get();
        $NaqtNow = 0;
        $PlastihNow = 0;
        foreach ($IshHaqiNow as $key => $value) {
            if($value->type=="Naqt"){
                $NaqtNow = $NaqtNow + $value->summa; 
            }else{
                $PlastihNow = $PlastihNow + $value->summa; 
            }
        }
        $DateEnd = date("Y-m",strtotime("-1 month",time()))."-01 00:00:00";
        $DateEnd3 = date("Y-m",strtotime("-1 month",time()))."-31 23:59:59";
        $IshHaqiEnd = IshHaqi::where('user_id',Auth::user()->id)->where('created_at','>=',$DateEnd)->where('created_at','<=',$DateEnd3)->get();
        $NaqtEnd = 0;
        $PlastihEnd = 0;
        foreach ($IshHaqiEnd as $key => $value) {
            if($value->type=="Naqt"){
                $NaqtEnd = $NaqtEnd + $value->summa; 
            }else{
                $PlastihEnd = $PlastihEnd + $value->summa; 
            }
        }
        $Tulov = array();
        $Tulov['NaqtNow'] = number_format(($NaqtNow), 0, '.', ' ');
        $Tulov['PlastihNow'] = number_format(($PlastihNow), 0, '.', ' ');
        $Tulov['NaqtEnd'] = number_format(($NaqtEnd), 0, '.', ' ');
        $Tulov['PlastihEnd'] = number_format(($PlastihEnd), 0, '.', ' ');
        return view('Techer.index',compact('Stat','Tulov'));
    }
    public function Guruhlar(){
        $times = date("Y-m-d",strtotime('-30 day',time()));
        $Guruhlar = Guruh::where('techer_id',Auth::user()->id)->where('guruh_status','true')->where('guruh_end','>=',$times)->get();
        $Guruh = array();
        foreach ($Guruhlar as $key => $value) {
            $Guruh[$key]['id'] = $value->id;
            $Guruh[$key]['guruh_name'] = $value->guruh_name;
            $Guruh[$key]['guruh_start'] = $value->guruh_start;
            $Guruh[$key]['guruh_end'] = $value->guruh_end;
            switch ($value->guruh_vaqt) {
                case '1':
                    $Guruh[$key]['guruh_vaqt'] = "08:00-09:30";
                    break;
                case '2':
                    $Guruh[$key]['guruh_vaqt'] = "09:30-11:00";
                    break;
                case '3':
                    $Guruh[$key]['guruh_vaqt'] = "11:00-12:30";
                    break;
                case 4:
                    $Guruh[$key]['guruh_vaqt'] = "12:30-14:00";
                    break;
                case '5':
                    $Guruh[$key]['guruh_vaqt'] = "14:00-15:30";
                    break;
                case '6':
                    $Guruh[$key]['guruh_vaqt'] = "15:30-17:00";
                    break;
                case '7':
                    $Guruh[$key]['guruh_vaqt'] = "17:00-18:30";
                    break;
                case '8':
                    $Guruh[$key]['guruh_vaqt'] = "18:30-20:00";
                    break;
                case '9':
                    $Guruh[$key]['guruh_vaqt'] = "20:00-21:30";
                    break;
            }
            $Guruh[$key]['users'] = count(GuruhUser::where('guruh_id',$value->id)->where('status','true')->get());
        }
        return view('Techer.grops',compact('Guruh'));
    }
    public function Tolovlar(){
        $IshHaqi = IshHaqi::where('user_id',Auth::user()->id)
            ->where('status','!=','Hodim')
            ->orderby('id','desc')
            ->get();
        $Tulov = array();
        foreach ($IshHaqi as $key => $value) {
            $Tulov[$key]['id'] = $value->id;
            $Tulov[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Tulov[$key]['type'] = $value->type;
            $Tulov[$key]['about'] = $value->about;
            $Tulov[$key]['time'] = $value->created_at;
            $Tulov[$key]['guruh'] = Guruh::find($value->status)->guruh_name;
        }
        #dd($Tulov);
        return view('Techer.pays',compact('Tulov'));
    }
    public function Kabinet(){
        return view('Techer.kabinet');
    }
    public function KabinetTUpdate(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'addres' => 'required',
            'phone' => 'required',
            'tkun' => 'required',
        ]);
        User::find(Auth::user()->id)->update($validated);
        return redirect()->back()->with('success', "Ma'lumotlar yangilandi."); 
    }
    public function KabinetTUpdatePassword(Request $request){
        $validated = $request->validate([
            'passw1' => 'required', 'min:8',
            'passw2' => 'required', 'min:8',
        ]);
        if($request->passw1 != $request->passw2){
            return redirect()->back()->with('error', "Parol moslar mos kelmadi."); 
        }
        $User = User::find(Auth::user()->id);
        $User->password = Hash::make($request->passw2);
        $User->save();
        return redirect()->back()->with('success', "Parol yangilandi."); 
    }
    public function show($id){
        $Guruhlar = Guruh::find($id);
        $Guruh = array();
        $Guruh['id'] = $Guruhlar->id;
        $Guruh['guruh_name'] = $Guruhlar->guruh_name;
        $Guruh['guruh_start'] = $Guruhlar->guruh_start;
        $Guruh['guruh_end'] = $Guruhlar->guruh_end;
        $Guruh['techerPay'] = $Guruhlar->techer_price;
        $Guruh['meneger'] = User::find($Guruhlar->admin_id)->email;
        $Guruh['TecherBonus'] = $Guruhlar->techer_bonus;
        $Guruh['room'] = Room::find($Guruhlar->room_id)->room_name;
        switch ($Guruhlar->guruh_vaqt) {
            case '1':
                $Guruh['guruh_vaqt'] = "08:00-09:30";
                break;
            case '2':
                $Guruh['guruh_vaqt'] = "09:30-11:00";
                break;
            case '3':
                $Guruh['guruh_vaqt'] = "11:00-12:30";
                break;
            case 4:
                $Guruh['guruh_vaqt'] = "12:30-14:00";
                break;
            case '5':
                $Guruh['guruh_vaqt'] = "14:00-15:30";
                break;
            case '6':
                $Guruh['guruh_vaqt'] = "15:30-17:00";
                break;
            case '7':
                $Guruh['guruh_vaqt'] = "17:00-18:30";
                break;
            case '8':
                $Guruh['guruh_vaqt'] = "18:30-20:00";
                break;
            case '9':
                $Guruh['guruh_vaqt'] = "20:00-21:30";
                break;
        }
        $Guruh['users'] = count(GuruhUser::where('guruh_id',$id)->where('status','true')->get());
        $Guruh['kunlar'] = GuruhTime::where('guruh_id',$Guruhlar->id)->where('room_id',$Guruhlar->room_id)->get();
        $Guruh['darskuni'] = count(GuruhTime::where('guruh_id',$Guruhlar->id)->where('dates',date('Y-m-d'))->get());
        $Guruh['davomatOlindi'] = count(Davomat::where('guruh_id',$id)->where('dates',date("Y-m-d"))->get());
        $DavUser = array();
        foreach(GuruhUser::where('guruh_id',$id)->where('status','true')->get() as $key => $item){
            $DavUser[$key]['user_id'] = $item->user_id;
            $DavUser[$key]['name'] = User::find($item->user_id)->name;
        }
        $Guruh['davUser'] = $DavUser;
        
        $Davomat = array();
        foreach (GuruhUser::where('guruh_id',$id)->where('status','true')->get() as $key => $value) {
            $Davomat[$key]['name'] = User::find($value->user_id)->name;
            foreach (GuruhTime::where('guruh_id',$Guruhlar->id)->where('room_id',$Guruhlar->room_id)->get() as $key2 => $item) {
                if($item->dates>date('Y-m-d')){
                    $Davomat[$key]['status'][$key2] = 'new';
                }elseif($item->dates==date('Y-m-d')){
                    $Dav = Davomat::where('guruh_id',$id)->where('user_id',$value->user_id)->where('dates',date("Y-m-d"))->first();
                    if($Dav){
                        if($Dav->status=='true'){
                            $Davomat[$key]['status'][$key2] = 'DarsKuniTrue';
                        }else{
                            $Davomat[$key]['status'][$key2] = 'DarsKuniFalse';
                        }
                    }else{
                        $Davomat[$key]['status'][$key2] = 'DarsKuni';
                    }
                }else{
                    $Dav = Davomat::where('guruh_id',$id)->where('user_id',$value->user_id)->where('dates',$item->dates)->first();
                    if($Dav){
                        if($Dav->status=='true'){
                            $Davomat[$key]['status'][$key2] = 'DavomatBor';
                        }else{
                            $Davomat[$key]['status'][$key2] = 'DavomatYoq';
                        }
                    }else{
                        $Davomat[$key]['status'][$key2] = 'DarsOtilmadi';
                    }
                }
            }
        }
        $DarsKunlar = count($Guruh['kunlar']);
        $NatijaTest = TestNatija::where('guruh_id',$id)->get();
        $Natija = array();
        foreach ($NatijaTest as $key => $value) {
            $Natija[$key]['name'] = User::find($value->user_id)->name;
            $Natija[$key]['savol_count'] = $value->savol_count;
            $Natija[$key]['tugri_count'] = $value->tugri_count;
            $Natija[$key]['notugri_count'] = $value->notugri_count;
            $Natija[$key]['ball'] = $value->ball;
            $Natija[$key]['created_at'] = $value->created_at;
        }
        return view('Techer.grops_show',compact('Natija','Guruh','Davomat','DarsKunlar'));
    }
    public function davomat(Request $request){
        $guruh_id = $request->guruh_id;
        $GuruhUser = GuruhUser::where('guruh_id',$guruh_id)->where('status','true')->get();
        $Davomat = array();
        $k = 0;
        foreach($GuruhUser as $key => $item){
            $Davomat[$key]['user_id'] = $item->user_id;
            $Davomat[$key]['user_name'] = User::find($item->user_id)->name;
            $req = strval('user_id'.$item->user_id);
            if($request->$req == 'on'){
                $Davomat[$key]['user_name'] = "true";
                $k = $k + 1;
            }else{
                $Davomat[$key]['user_name'] = "false";
            }
        }
        if($k==0){
            return redirect()->back()->with('error', "Davomat uchun talabalarni tanlamadingiz."); 
        }else{
            $filial_id = auth()->user()->filial_id;
            foreach ($Davomat as $key => $value) {
                Davomat::create([
                    'filial_id' => $filial_id,
                    'guruh_id' => $guruh_id,
                    'user_id' => $value['user_id'],
                    'dates' => date("Y-m-d"),
                    'status' => $value['user_name'],
                    'techer_id' => Auth::user()->id
                ]);
            }
            return redirect()->back()->with('success', "Guruh uchun davomat olindi."); 
        }
    }
}
