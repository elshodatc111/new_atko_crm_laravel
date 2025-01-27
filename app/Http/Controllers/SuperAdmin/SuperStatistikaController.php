<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\User;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\Tulov;
use App\Models\IshHaqi;
use App\Models\Guruh;
use App\Models\Blog;
use App\Models\Moliya;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuperStatistikaController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function oxirgiYittiKun(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
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
    public function KunlikTashrivAndCRM($filial_id){
        $Kunlar = $this->oxirgiYittiKun();
        $Statistika = array();
        $Tashriflar = array();
        foreach ($Kunlar as $key => $value) {
            $Start = $value['date']." 00:00:00";
            $End = $value['date']." 23:59:59";
            $Tashriflar[$key]['day_name'] = $value['day_name'];
            $Tashriflar[$key]['user_count'] = count(User::where('filial_id',$filial_id)->where('created_at','>=',$Start)->where('created_at','<=',$End)->get());
        }
        $Statistika['kunlik_tashrif'] = $Tashriflar;
        $Statrs = Carbon::now()->subDays(6)->format('Y-m-d')." 00:00:00";
        $Nows = Carbon::now()->subDays(0)->format('Y-m-d')." 23:59:59";
        $SNNN = User::where('filial_id',$filial_id)->where('created_at','>=',$Statrs)->where('created_at','<=',$Nows)->get();
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
    public function KunlikTulovlar($filial_id){
        $Kunlar = $this->oxirgiYittiKun();
        $Tulovlar = array();
        foreach ($Kunlar as $key => $value) {
            $Start = $value['date']." 00:00:00";
            $End = $value['date']." 23:59:59";

            $Tulovlar[$key]['date'] = $value['date'];
            $Tulovlar[$key]['date_wekend'] = $value['date_wekend'];

            $Tulov = Tulov::where('created_at','>=',$Start)
                ->where('filial_id',$filial_id)
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
    public function OxirgiYittiOy(){
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subMonth($i);
            $dayName = $date->format('l');
            $weekDays[] = [
                'month' => $date->format('Y-m'),
                'month_text' => $date->format('Y-M'),
            ];
        }
        return array_reverse($weekDays);
    }
    public function OxirgiBirYilOylar(){
        $weekDays = [];
        for ($i = 0; $i < 13; $i++) {
            $date = Carbon::now()->subMonth($i);
            $dayName = $date->format('l');
            $weekDays[] = [
                'month' => $date->format('Y-m'),
                'month_text' => $date->format('Y-M'),
            ];
        }
        return array_reverse($weekDays);
    }
    public function AllTashriflarFilial($filial_id){
        $Oylar = $this->OxirgiYittiOy();
        $Tashriflar = array();
        foreach ($Oylar as $key => $value) {
            $Start = $value['month']."-01 00:00:00";
            $End = $value['month']."-31 23:59:59";
            $Users = User::where('filial_id',$filial_id)->where('created_at','>=',$Start)->where('created_at','<=',$End)->get();
            $Tashriflar[$key]['month'] = $value['month_text'];
            $Tashriflar[$key]['tashriflar'] = count($Users);
            
        }
        $date = Carbon::now()->subMonth(1)->format("Y-m")."-01 00:00:00";
        $Users2 = User::where('filial_id',$filial_id)->where('created_at','>=',$date)->get();
        $telegram = 0;
        $instagram = 0;
        $facebook = 0;
        $banner = 0;
        $tanishlar = 0;
        $boshqalar = 0;
        foreach ($Users2 as $value) {
            if($value->smm == 'Telegram'){$telegram = $telegram + 1;}
            if($value->smm == 'Instagram'){$instagram = $instagram + 1;}
            if($value->smm == 'Facebook'){$facebook = $facebook + 1;}
            if($value->smm == 'Boshqa'){$boshqalar = $boshqalar + 1;}
            if($value->smm == 'Tanishlar'){$tanishlar = $tanishlar + 1;}
            if($value->smm == 'Bannerlar'){$banner = $banner + 1;}
        }
        $Tashriflar['telegram'] = $telegram;
        $Tashriflar['instagram'] = $instagram;
        $Tashriflar['facebook'] = $facebook;
        $Tashriflar['banner'] = $banner;
        $Tashriflar['tanishlar'] = $tanishlar;
        $Tashriflar['boshqalar'] = $boshqalar;
        return $Tashriflar;
    }
    public function activTalabalarFilial($filial_id){
        $Actives = array();
        foreach ($this->OxirgiYittiOy() as $key => $date) {
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Guruhsss = Guruh::where('guruh_start','<=',$EndDates)
                ->where('filial_id','<=',$filial_id)
                ->where('guruh_end','>=',$StartDates)->get();
            $ActivUser = array();
            foreach ($Guruhsss as $value) {
                $GuruhUsersss = GuruhUser::where('guruh_id',$value->id)
                    ->where('filial_id','<=',$filial_id)->get();
                foreach ($GuruhUsersss as $key11 => $item) {
                    $userss_id = $item->user_id;
                    $km = 0;
                    foreach ($ActivUser as $keyaaaas => $valueaaaas) {
                        if($valueaaaas==$userss_id){
                            $km++;
                        }
                    }
                    if($km==0){
                        array_push($ActivUser, $userss_id);
                    }   
                }
            }
            $Actives[$key]['count'] = count($ActivUser); 
            $Actives[$key]['data'] = $date['month_text']; 
        }
        return $Actives;
    }
    public function OylikTulovFilial($filial_id){
        $Statistik = array();
        foreach ($this->OxirgiYittiOy() as $key => $date) {
            $Statistik[$key]['date'] = $date['month_text'];
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Naqt = 0;
            $Plastik = 0;
            $Payme = 0;
            $Chegirma = 0;
            $Qaytar = 0;
            $Xarajatlar = 0;
            $IshHaq = 0;
            $Tulov = Tulov::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($Tulov as $value) {
                if($value->type=='Naqt'){$Naqt = $Naqt + $value->summa;}
                if($value->type=='Plastik'){$Plastik = $Plastik + $value->summa;}
                if($value->type=='Payme'){$Payme = $Payme + $value->summa;}
                if($value->type=='Chegirma'){$Chegirma = $Chegirma + $value->summa;}
                if($value->type=='Qaytarildi (Plastik)'){$Qaytar = $Qaytar + $value->summa;}
                if($value->type=='Qaytarildi (Naqt)'){$Qaytar = $Qaytar + $value->summa;}
            }
            $Moliya = Moliya::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($Moliya as $value) {
                if($value->xodisa=='Xarajat'){$Xarajatlar = $Xarajatlar + $value->summa;}
                if($value->xodisa=='XarajatAdmin'){$Xarajatlar = $Xarajatlar + $value->summa;}
            }
            $IshHaqi = IshHaqi::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($IshHaqi as $value) {$IshHaq = $IshHaq + $value->summa;}
            $Statistik[$key]['Naqt'] = $Naqt;
            $Statistik[$key]['Naqt_table'] = number_format(($Naqt), 0, '.', ' ');
            $Statistik[$key]['Plastik'] = $Plastik;
            $Statistik[$key]['Plastik_table'] = number_format(($Plastik), 0, '.', ' ');
            $Statistik[$key]['Payme'] = $Payme;
            $Statistik[$key]['Payme_table'] = number_format(($Payme), 0, '.', ' ');
            $Statistik[$key]['Chegirma'] = $Chegirma;
            $Statistik[$key]['Chegirma_table'] = number_format(($Chegirma), 0, '.', ' ');
            $Statistik[$key]['Qaytar'] = $Qaytar;
            $Statistik[$key]['Qaytar_table'] = number_format(($Qaytar), 0, '.', ' ');
            $TulovSum = $Naqt + $Plastik + $Payme -$Qaytar;
            $Statistik[$key]['Tulovlar'] = $TulovSum;
            $Statistik[$key]['TulovSum_table'] = number_format(($TulovSum), 0, '.', ' ');
            $Statistik[$key]['Xarajatlar'] = $Xarajatlar;
            $Statistik[$key]['Xarajatlar_table'] = number_format(($Xarajatlar), 0, '.', ' ');
            $Statistik[$key]['IshHaq'] = $IshHaq;
            $Statistik[$key]['IshHaq_table'] = number_format(($IshHaq), 0, '.', ' ');
            $Daromat = $TulovSum - $Xarajatlar - $IshHaq;
            $Statistik[$key]['Daromat'] = $Daromat;
            $Statistik[$key]['Daromat_table'] = number_format(($Daromat), 0, '.', ' ');
        }
        return $Statistik;
    }
    public function YillikStatistikaFilial($filial_id){
        $Statistik = array();
        foreach ($this->OxirgiBirYilOylar() as $key => $date) {
            $Statistik[$key]['date'] = $date['month_text'];
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Naqt = 0;
            $Plastik = 0;
            $Payme = 0;
            $Qaytar = 0;
            $Xarajatlar = 0;
            $IshHaq = 0;
            $Tulov = Tulov::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($Tulov as $value) {
                if($value->type=='Naqt'){$Naqt = $Naqt + $value->summa;}
                if($value->type=='Plastik'){$Plastik = $Plastik + $value->summa;}
                if($value->type=='Payme'){$Payme = $Payme + $value->summa;}
                if($value->type=='Qaytarildi (Plastik)'){$Qaytar = $Qaytar + $value->summa;}
                if($value->type=='Qaytarildi (Naqt)'){$Qaytar = $Qaytar + $value->summa;}
            }
            $Moliya = Moliya::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($Moliya as $value) {
                if($value->xodisa=='Xarajat'){$Xarajatlar = $Xarajatlar + $value->summa;}
                if($value->xodisa=='XarajatAdmin'){$Xarajatlar = $Xarajatlar + $value->summa;}
            }
            $IshHaqi = IshHaqi::where('created_at','>=',$StartDates)->where('filial_id','<=',$filial_id)->where('created_at','<=',$EndDates)->get();
            foreach ($IshHaqi as $value) {$IshHaq = $IshHaq + $value->summa;}
            $TulovSum = $Naqt + $Plastik + $Payme -$Qaytar;
            $Statistik[$key]['Tulov'] = $TulovSum;
            $Xarajat = $Xarajatlar + $IshHaq;
            $Statistik[$key]['Xarajat'] = $Xarajat;
        }
        return $Statistik;
    }
    public function index($filial_id){
        $Tashriflar = $this->AllTashriflarFilial($filial_id);
        $Active = $this->activTalabalarFilial($filial_id);
        $OylikTulovAll = $this->OylikTulovFilial($filial_id);
        $Yillik = $this->YillikStatistikaFilial($filial_id);
        return view('SuperAdmin.statistik.index',compact('Yillik','filial_id','Tashriflar','Active','OylikTulovAll'));
    }
    public function AllTashriflar(){
        $Oylar = $this->OxirgiYittiOy();
        $Tashriflar = array();
        foreach ($Oylar as $key => $value) {
            $Start = $value['month']."-01 00:00:00";
            $End = $value['month']."-31 23:59:59";
            $Users = User::where('created_at','>=',$Start)->where('created_at','<=',$End)->get();
            $Tashriflar[$key]['month'] = $value['month_text'];
            $Tashriflar[$key]['tashriflar'] = count($Users);
            
        }
        $date = Carbon::now()->subMonth(1)->format("Y-m")."-01 00:00:00";
        $Users2 = User::where('created_at','>=',$date)->get();
        $telegram = 0;
        $instagram = 0;
        $facebook = 0;
        $banner = 0;
        $tanishlar = 0;
        $boshqalar = 0;
        foreach ($Users2 as $value) {
            if($value->smm == 'Telegram'){$telegram = $telegram + 1;}
            if($value->smm == 'Instagram'){$instagram = $instagram + 1;}
            if($value->smm == 'Facebook'){$facebook = $facebook + 1;}
            if($value->smm == 'Boshqa'){$boshqalar = $boshqalar + 1;}
            if($value->smm == 'Tanishlar'){$tanishlar = $tanishlar + 1;}
            if($value->smm == 'Bannerlar'){$banner = $banner + 1;}
        }
        $Tashriflar['telegram'] = $telegram;
        $Tashriflar['instagram'] = $instagram;
        $Tashriflar['facebook'] = $facebook;
        $Tashriflar['banner'] = $banner;
        $Tashriflar['tanishlar'] = $tanishlar;
        $Tashriflar['boshqalar'] = $boshqalar;
        return $Tashriflar;
    }
    public function activTalabalarAll(){
        $Actives = array();
        foreach ($this->OxirgiYittiOy() as $key => $date) {
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Guruhsss = Guruh::where('guruh_start','<=',$EndDates)
                ->where('guruh_end','>=',$StartDates)->get();
            $ActivUser = array();
            foreach ($Guruhsss as $value) {
                $GuruhUsersss = GuruhUser::where('guruh_id',$value->id)->get();
                foreach ($GuruhUsersss as $key11 => $item) {
                    $userss_id = $item->user_id;
                    $km = 0;
                    foreach ($ActivUser as $keyaaaas => $valueaaaas) {
                        if($valueaaaas==$userss_id){
                            $km++;
                        }
                    }
                    if($km==0){
                        array_push($ActivUser, $userss_id);
                    }   
                }
            }
            $Actives[$key]['count'] = count($ActivUser); 
            $Actives[$key]['data'] = $date['month_text']; 
        }
        return $Actives;
    }
    public function OylikTulovAll(){
        $Statistik = array();
        foreach ($this->OxirgiYittiOy() as $key => $date) {
            $Statistik[$key]['date'] = $date['month_text'];
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Naqt = 0;
            $Plastik = 0;
            $Payme = 0;
            $Chegirma = 0;
            $Qaytar = 0;
            $Xarajatlar = 0;
            $IshHaq = 0;
            $Tulov = Tulov::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($Tulov as $value) {
                if($value->type=='Naqt'){$Naqt = $Naqt + $value->summa;}
                if($value->type=='Plastik'){$Plastik = $Plastik + $value->summa;}
                if($value->type=='Payme'){$Payme = $Payme + $value->summa;}
                if($value->type=='Chegirma'){$Chegirma = $Chegirma + $value->summa;}
                if($value->type=='Qaytarildi (Plastik)'){$Qaytar = $Qaytar + $value->summa;}
                if($value->type=='Qaytarildi (Naqt)'){$Qaytar = $Qaytar + $value->summa;}
            }
            $Moliya = Moliya::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($Moliya as $value) {
                if($value->xodisa=='Xarajat'){$Xarajatlar = $Xarajatlar + $value->summa;}
                if($value->xodisa=='XarajatAdmin'){$Xarajatlar = $Xarajatlar + $value->summa;}
            }
            $IshHaqi = IshHaqi::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($IshHaqi as $value) {$IshHaq = $IshHaq + $value->summa;}
            $Statistik[$key]['Naqt'] = $Naqt;
            $Statistik[$key]['Naqt_table'] = number_format(($Naqt), 0, '.', ' ');
            $Statistik[$key]['Plastik'] = $Plastik;
            $Statistik[$key]['Plastik_table'] = number_format(($Plastik), 0, '.', ' ');
            $Statistik[$key]['Payme'] = $Payme;
            $Statistik[$key]['Payme_table'] = number_format(($Payme), 0, '.', ' ');
            $Statistik[$key]['Chegirma'] = $Chegirma;
            $Statistik[$key]['Chegirma_table'] = number_format(($Chegirma), 0, '.', ' ');
            $Statistik[$key]['Qaytar'] = $Qaytar;
            $Statistik[$key]['Qaytar_table'] = number_format(($Qaytar), 0, '.', ' ');
            $TulovSum = $Naqt + $Plastik + $Payme -$Qaytar;
            $Statistik[$key]['Tulovlar'] = $TulovSum;
            $Statistik[$key]['TulovSum_table'] = number_format(($TulovSum), 0, '.', ' ');
            $Statistik[$key]['Xarajatlar'] = $Xarajatlar;
            $Statistik[$key]['Xarajatlar_table'] = number_format(($Xarajatlar), 0, '.', ' ');
            $Statistik[$key]['IshHaq'] = $IshHaq;
            $Statistik[$key]['IshHaq_table'] = number_format(($IshHaq), 0, '.', ' ');
            $Daromat = $TulovSum - $Xarajatlar - $IshHaq;
            $Statistik[$key]['Daromat'] = $Daromat;
            $Statistik[$key]['Daromat_table'] = number_format(($Daromat), 0, '.', ' ');
        }
        return $Statistik;
    }
    public function YillikStatistikaAll(){
        $Statistik = array();
        foreach ($this->OxirgiBirYilOylar() as $key => $date) {
            $Statistik[$key]['date'] = $date['month_text'];
            $StartDates = $date['month']."-01 00:00:00";
            $EndDates = $date['month']."-31 23:59:59";
            $Naqt = 0;
            $Plastik = 0;
            $Payme = 0;
            $Qaytar = 0;
            $Xarajatlar = 0;
            $IshHaq = 0;
            $Tulov = Tulov::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($Tulov as $value) {
                if($value->type=='Naqt'){$Naqt = $Naqt + $value->summa;}
                if($value->type=='Plastik'){$Plastik = $Plastik + $value->summa;}
                if($value->type=='Payme'){$Payme = $Payme + $value->summa;}
                if($value->type=='Qaytarildi (Plastik)'){$Qaytar = $Qaytar + $value->summa;}
                if($value->type=='Qaytarildi (Naqt)'){$Qaytar = $Qaytar + $value->summa;}
            }
            $Moliya = Moliya::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($Moliya as $value) {
                if($value->xodisa=='Xarajat'){$Xarajatlar = $Xarajatlar + $value->summa;}
                if($value->xodisa=='XarajatAdmin'){$Xarajatlar = $Xarajatlar + $value->summa;}
            }
            $IshHaqi = IshHaqi::where('created_at','>=',$StartDates)->where('created_at','<=',$EndDates)->get();
            foreach ($IshHaqi as $value) {$IshHaq = $IshHaq + $value->summa;}
            $TulovSum = $Naqt + $Plastik + $Payme -$Qaytar;
            $Statistik[$key]['Tulov'] = $TulovSum;
            $Xarajat = $Xarajatlar + $IshHaq;
            $Statistik[$key]['Xarajat'] = $Xarajat;
        }
        return $Statistik;
    }
    public function statistikaMonth(){
        $Tashriflar = $this->AllTashriflar();
        $Active = $this->activTalabalarAll();
        $OylikTulovAll = $this->OylikTulovAll();
        $Yillik = $this->YillikStatistikaAll();
        #dd($Yillik);
        return view('SuperAdmin.statistik.oy',compact('Tashriflar','Active','OylikTulovAll','Yillik'));
    }
    public function statistikaKun($filial_id){
        $TashSMM = $this->KunlikTashrivAndCRM($filial_id); 
        $Tulov = $this->KunlikTulovlar($filial_id); 
        return view('SuperAdmin.statistik.kunlik',compact('Tulov','TashSMM','filial_id'));
    }
    public function statistikaForm(){
        $now = date("Y-m-d")." 23:59:59";
        $monch = date('Y-m-d', strtotime('-30 days', time()))." 00:00:00";
        $years = date('Y-m-d', strtotime('-365 days', time()))." 00:00:00";
        $Monch = array();
        $Blog = Blog::get();
        $FormY = 0;
        $RegY = 0;
        $GurY = 0;
        $TulY = 0;
        $FormO = 0;
        $RegO = 0;
        $GurO = 0;
        $TulO = 0;
        foreach ($Blog as $key => $value) {
            if($value['created_at']>=$monch){
                $FormO = $FormO + 1;
                if($value['status']=='register'){
                    $RegO = $RegO + 1;
                    $User_id = $value['user_id'];
                    $GuruhUsers = count(GuruhUser::where('user_id',$User_id)->where('status','true')->get());
                    if($GuruhUsers>0){
                        $GurO = $GurO + 1;
                    }
                    $Tulovlar = count(Tulov::where('user_id',$User_id)->get());
                    if($Tulovlar>0){
                        $TulO = $TulO +1;
                    }
                }
            }
            if($value['created_at']>=$years){
                $FormY = $FormY + 1;
                if($value['status']=='register'){
                    $RegY = $RegY + 1;
                    $User_id = $value['user_id'];
                    $GuruhUsers = count(GuruhUser::where('user_id',$User_id)->where('status','true')->get());
                    if($GuruhUsers>0){
                        $GurY = $GurY + 1;
                    }
                    $Tulovlar = count(Tulov::where('user_id',$User_id)->get());
                    if($Tulovlar>0){
                        $TulY = $TulY +1;
                    }
                }
            }
        }
        $Monch['FormY'] = $FormY;
        $Monch['RegY'] = $RegY;
        $Monch['GurY'] = $GurY;
        $Monch['TulY'] = $TulY;
        $Monch['FormO'] = $FormO;
        $Monch['RegO'] = $RegO;
        $Monch['GurO'] = $GurO;
        $Monch['TulO'] = $TulO;
        return view('SuperAdmin.statistik.form_statistik',compact('Monch'));
    }
}
