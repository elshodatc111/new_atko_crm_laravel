<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\User;
use App\Models\FilialKassa;
use App\Models\IshHaqi;
use App\Models\Guruh;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\GuruhTime;
use App\Models\Davomat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminTecherController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function tulovlar($techer_id,$guruh_id){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        $tulov = 0;
        $IshHaqi = IshHaqi::where('user_id',$techer_id)->where('status',$guruh_id)->get();
        foreach ($IshHaqi as $items) {$tulov = $tulov + $items->summa;}
        return $tulov;
    }
    public function ishHaqiHisoblash($guruh_id){
        $CountTalaba = count(GuruhUser::where('guruh_id',$guruh_id)->where('status','true')->get());
        $CountLessen = count(GuruhTime::where('guruh_id',$guruh_id)->get());
        $DarsKunlar = GuruhTime::where('guruh_id',$guruh_id)->get();
        $DavomatCount = 0;
        foreach ($DarsKunlar as $key => $value) {
            $Dav = count(Davomat::where('dates',$value->dates)->where('guruh_id',$guruh_id)->get());
            if($Dav>1){$DavomatCount = $DavomatCount + 1;}
        }
        $TecherTulov = Guruh::find($guruh_id)->techer_price;
        $TecherBonus = Guruh::find($guruh_id)->techer_bonus;
        if($CountLessen==0){$CountLessen=1;}
        $Hisoblash = $TecherTulov/$CountLessen*$DavomatCount*$CountTalaba;
        $Student = GuruhUser::where('guruh_id',$guruh_id)->where('status','true')->get();
        $bonuss = 0;
        foreach ($Student as $talaba) {
            $BonusTalaba = count(GuruhUser::where('user_id',$talaba->user_id)
                ->where('created_at','>=',$talaba->created_at)->where('status','true')->get());
            if($BonusTalaba>1){
                $bonuss = $bonuss+1;
            }
        }
        $Hisoblash2 = $Hisoblash + $bonuss*$TecherBonus;
        return $Hisoblash2;
    }
    public function index(){
        $time = date('Y-m-d',strtotime('-1 month',time()));
        $Report = array();
        $Guruhlar = Guruh::where('guruh_end','>=',$time)->get();
        foreach ($Guruhlar as $key => $value) {
            $Report[$key]['filial_name'] = Filial::find($value->filial_id)->filial_name;
            $Report[$key]['guruh_name'] = $value->guruh_name;
            $Report[$key]['techer'] = User::find($value->techer_id)->name;
            $Report[$key]['hisoblash'] = $this->ishHaqiHisoblash($value->id);
            $Report[$key]['hisoblash2'] = number_format($Report[$key]['hisoblash'], 0, '.', ' ');
            $Report[$key]['tulov'] = $this->tulovlar($value->techer_id,$value->id);
            $Report[$key]['tulov2'] = number_format($this->tulovlar($value->techer_id,$value->id), 0, '.', ' ');
            $Report[$key]['qoldiq'] = $Report[$key]['hisoblash']-$Report[$key]['tulov'];
            $Report[$key]['qoldiq2'] = number_format($Report[$key]['hisoblash']-$Report[$key]['tulov'], 0, '.', ' ');
        }
        return view('SuperAdmin.techer.index',compact('Report'));
    }
}
