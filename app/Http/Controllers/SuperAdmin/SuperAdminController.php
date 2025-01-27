<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SmsCounter;
use App\Models\Guruh;
use App\Models\GuruhUser;
use App\Models\Filial;
use App\Models\Setting;
use App\Models\Tulov;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuperAdminController extends Controller{
    public function __construct(){$this->middleware('auth');}
    public function oxirgiYittiKun(){
        $weekDays = [];
        $daysOfWeek = [
            'Sunday' => 'Yakshanba',
            'Monday' => 'Dushanba',
            'Tuesday' => 'Seshanba',
            'Wednesday' => 'Chorshanba',
            'Thursday' => 'Payshanba',
            'Friday' => 'Juma',
            'Saturday' => 'Shanba',
        ];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->format('l');
            $palmDayName = $daysOfWeek[$dayName];
            $weekDays[] = [
                'day_name' => $palmDayName,
                'date' => $date->format('Y-m-d'),
                'date_wekend' => $date->format('d-M')
            ];
        }
        $weekDays = array_reverse($weekDays);
        return $weekDays;
    } 
    public function KunlikTashrivAndCRM(){
        $Kunlar = $this->oxirgiYittiKun();
        $Statistika = array();
        $Tashriflar = array();
        foreach ($Kunlar as $key => $value) {
            $Start = $value['date']." 00:00:00";
            $End = $value['date']." 23:59:59";
            $Tashriflar[$key]['day_name'] = $value['day_name'];
            $Tashriflar[$key]['user_count'] = count(User::where('created_at','>=',$Start)->where('created_at','<=',$End)->get());
        }
        $Statistika['kunlik_tashrif'] = $Tashriflar;
        $Statrs = Carbon::now()->subDays(6)->format('Y-m-d')." 00:00:00";
        $Nows = Carbon::now()->subDays(0)->format('Y-m-d')." 23:59:59";
        $SNNN = User::where('created_at','>=',$Statrs)->where('created_at','<=',$Nows)->get();
        $SMM = array();
        $telegram = 0;
        $instagram = 0;
        $facebook = 0;
        $banner = 0;
        $tanishlar = 0;
        $boshqalar = 0;
        foreach ($SNNN as $key => $value) {
            if($value->smm=='Telegram'){$telegram = $telegram + 1;}
            if($value->smm=='Instagram'){$instagram = $instagram + 1;}
            if($value->smm=='Facebook'){$facebook = $facebook + 1;}
            if($value->smm=='Bannerlar'){$banner = $banner + 1;}
            if($value->smm=='Tanishlar'){$tanishlar = $tanishlar + 1;}
            if($value->smm=='Boshqa'){$boshqalar = $boshqalar + 1;}
        }
        $SMM['Telegram'] = $telegram;
        $SMM['Instagram'] = $instagram;
        $SMM['Facebook'] = $facebook;
        $SMM['Banner'] = $banner;
        $SMM['Tanishlar'] = $tanishlar;
        $SMM['Boshqalar'] = $boshqalar;
        $Statistika['smm'] = $SMM;
        return $Statistika;
    }
    public function KunlikTulovlar(){
        $Kunlar = $this->oxirgiYittiKun();
        $Tulovlar = array();
        foreach ($Kunlar as $key => $value) {
            $Start = $value['date']." 00:00:00";
            $End = $value['date']." 23:59:59";

            $Tulovlar[$key]['date'] = $value['date'];
            $Tulovlar[$key]['date_wekend'] = $value['date_wekend'];

            $Tulov = Tulov::where('created_at','>=',$Start)
                ->where('created_at','<=',$End)->get();
            $Naqt = 0;
            $Plastik = 0;
            $Payme = 0;
            $Chegirma = 0;
            $Qaytarildi = 0;
            $Naqt_Plastik_Payme = 0;
            foreach ($Tulov as $value) {
                if($value->type=='Naqt'){
                    $Naqt = $Naqt + $value['summa'];
                    $Naqt_Plastik_Payme = $Naqt_Plastik_Payme + $value['summa'];
                }
                if($value->type=='Plastik'){
                    $Plastik = $Plastik + $value['summa'];
                    $Naqt_Plastik_Payme = $Naqt_Plastik_Payme + $value['summa'];
                }
                if($value->type=='Payme'){
                    $Payme = $Payme + $value['summa'];
                    $Naqt_Plastik_Payme = $Naqt_Plastik_Payme + $value['summa'];
                }
                if($value->type=='Chegirma'){$Chegirma = $Chegirma + $value['summa'];}
                if($value->type=='Qaytarildi (Plastik)'){$Qaytarildi = $Qaytarildi + $value['summa'];}
                if($value->type=='Qaytarildi (Naqt)'){$Qaytarildi = $Qaytarildi + $value['summa'];}
            }
            
            $Tulovlar[$key]['Naqt'] = $Naqt;
            $Tulovlar[$key]['Plastik'] = $Plastik;
            $Tulovlar[$key]['Payme'] = $Payme;
            $Tulovlar[$key]['Chegirma'] = $Chegirma;
            $Tulovlar[$key]['Qaytarildi'] = $Qaytarildi;
            $Tulovlar[$key]['Naqt_Plastik_Payme'] = $Naqt_Plastik_Payme;
            $Tulovlar[$key]['Table_Naqt'] = number_format(($Naqt), 0, '.', ' ');
            $Tulovlar[$key]['Table_Plastik'] = number_format(($Plastik), 0, '.', ' ');
            $Tulovlar[$key]['Table_Payme'] = number_format(($Payme), 0, '.', ' ');
            $Tulovlar[$key]['Table_Chegirma'] = number_format(($Chegirma), 0, '.', ' ');
            $Tulovlar[$key]['Table_Qaytarildi'] = number_format(($Qaytarildi), 0, '.', ' ');
            $Tulovlar[$key]['Table_Naqt_Plastik_Payme'] = number_format(($Naqt_Plastik_Payme), 0, '.', ' ');
        }
        return $Tulovlar;
    } 
    public function index(){
        $SmsCounter = SmsCounter::find(1);
        $SettingEndData = date("Y-m-d", strtotime('-3 day',strtotime(Setting::find(1)->EndData)));
        $times = date("Y-m-d");
        if($times>$SettingEndData){$Block = 'true';
        }else{$Block = "false";}
        $Filiallar = Filial::get();
        $Filial = array();
        foreach ($Filiallar as $key => $value) {
            $Filial[$key]['filial_name'] = $value->filial_name;
            $Filial[$key]['user'] = count(User::where('filial_id',$value->id)->where('type','User')->get());
            $Filial[$key]['techer'] = count(User::where('filial_id',$value->id)->where('type','Techer')->get());
            $Filial[$key]['meneger'] = count(User::where('filial_id',$value->id)->where('type','Admin')->get())+count(User::where('filial_id',$value->id)->where('type','Operator')->get());
            $Filial[$key]['guruhlar'] = count(Guruh::where('filial_id',$value->id)->get());
            $Filial[$key]['yangiguruh'] = count(Guruh::where('filial_id',$value->id)->where('guruh_start','>',date('Y-m-d'))->get());
            $Filial[$key]['aktivguruh'] = count(Guruh::where('filial_id',$value->id)->get())-count(Guruh::where('filial_id',$value->id)->where('guruh_start','>',date('Y-m-d'))->get())-count(Guruh::where('filial_id',$value->id)->where('guruh_end','<',date('Y-m-d'))->get());
            $Filial[$key]['endguruh'] = count(Guruh::where('filial_id',$value->id)->where('guruh_end','<',date('Y-m-d'))->get());
        }
        $StartDates = date("Y-m")."-01 00:00:00";
        $EndDates = date("Y-m")."31 23:59:59";
        $Guruhsss = Guruh::where('guruh_start','<=',$EndDates)->where('guruh_end','>=',$StartDates)->get();
        $ActivUser = array();
        $ActivTulovUser = 0;
        foreach ($Guruhsss as $key => $value) {
            $GuruhUsersss = GuruhUser::where('guruh_id',$value->id)->where('status','true')->get();
            foreach ($GuruhUsersss as $key11 => $item) {
                $userss_id = $item->user_id;
                $km = 0;
                foreach ($ActivUser as $keyaaaas => $valueaaaas) {
                    if($valueaaaas==$userss_id){
                        $Tulov11 = Tulov::where('user_id',$userss_id)->where('status','true')->where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
                        if($Tulov11){
                            $ActivTulovUser = $ActivTulovUser + 1;
                        }
                        $km++;
                    }
                }
                if($km==0){
                    array_push($ActivUser, $userss_id);
                }   
            }
        }
        $ActivStudent = count($ActivUser); // Aktiv talabalar
        $TashSMM = $this->KunlikTashrivAndCRM(); // Tashriflar va SMM
        $Tulov = $this->KunlikTulovlar();
        #dd($Tulov);
        return view('SuperAdmin.index',compact('Tulov','TashSMM','Filial','Block','SmsCounter','ActivStudent','ActivTulovUser'));
    }    
    public function tulovShow($data){
        $Start = $data." 00:00:00";
        $End = $data." 23:59:59";
        $Tulov = Tulov::where('created_at','>=',$Start)->where('created_at','<=',$End)->get();
        $Tulovlar = array();
        foreach ($Tulov as $key => $value) {
            $Tulovlar[$key]['Filial'] = Filial::find($value->filial_id)->filial_name;
            $Tulovlar[$key]['User'] = User::find($value->user_id)->name;
            $Tulovlar[$key]['Admin'] = User::find($value->admin_id)->email;
            $Tulovlar[$key]['Summa'] = number_format(($value->summa), 0, '.', ' ');
            $Tulovlar[$key]['Type'] = $value->type;
            $Tulovlar[$key]['About'] = $value->about;
            $Tulovlar[$key]['created_at'] = $value->created_at;
        }
        #dd($Tulovlar);
        return view('SuperAdmin.statistik.kunlik_tulov',compact('data','Tulovlar'));
    }
}
