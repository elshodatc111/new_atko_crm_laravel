<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\User;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\Guruh;
use App\Models\Tulov;
use App\Models\Moliya;
use App\Models\Cours;
use App\Models\IshHaqi;
use App\Models\Room;
use App\Models\TestNatija;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportControlle extends Controller{
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        return view('SuperAdmin.hisobot.index');
    }
    public function Tashriflar(){
        $User = User::where('type','User')->get();
        $Users = array();
        foreach ($User as $key => $value) {
            $Users[$key]['id'] = $value->id;
            $Users[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Users[$key]['name'] = $value->name;
            $Users[$key]['addres'] = $value->addres;
            $Users[$key]['tkun'] = $value->tkun;
            $Users[$key]['phone'] = $value->phone;
            $Users[$key]['phone2'] = $value->phone2;
            $Users[$key]['about'] = $value->about;
            $Users[$key]['smm'] = $value->smm;
            $Users[$key]['balans'] = $value->balans;
            $Users[$key]['login'] = $value->email;
            $Users[$key]['admin'] = User::find($value->admin_id)->name;
            $Users[$key]['created_at'] = $value->created_at;
        }
        return view('SuperAdmin.hisobot.users',compact('Users'));
    }
    public function Qarzdorlar(){
        $User = User::where('type','User')->where('balans','<',0)->get();
        $Users = array();
        foreach ($User as $key => $value) {
            $Users[$key]['id'] = $value->id;
            $Users[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Users[$key]['name'] = $value->name;
            $Users[$key]['addres'] = $value->addres;
            $Users[$key]['tkun'] = $value->tkun;
            $Users[$key]['phone'] = $value->phone;
            $Users[$key]['phone2'] = $value->phone2;
            $Users[$key]['about'] = $value->about;
            $Users[$key]['smm'] = $value->smm;
            $Users[$key]['balans'] = $value->balans;
            $Users[$key]['login'] = $value->email;
            $Users[$key]['admin'] = User::find($value->admin_id)->name;
            $Users[$key]['created_at'] = $value->created_at;
        }
        return view('SuperAdmin.hisobot.debit',compact('Users'));
    }
    public function guruhNoUsers(){
        $User = User::where('type','User')->get();
        $Users = array();
        foreach ($User as $key => $value) {
            $GuruhUser = count(GuruhUser::where('user_id',$value->id)->where('status','true')->get());
            if($GuruhUser==0){
                $Users[$key]['id'] = $value->id;
                $Users[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $Users[$key]['name'] = $value->name;
                $Users[$key]['addres'] = $value->addres;
                $Users[$key]['tkun'] = $value->tkun;
                $Users[$key]['phone'] = $value->phone;
                $Users[$key]['phone2'] = $value->phone2;
                $Users[$key]['about'] = $value->about;
                $Users[$key]['smm'] = $value->smm;
                $Users[$key]['balans'] = $value->balans;
                $Users[$key]['login'] = $value->email;
                $Users[$key]['admin'] = User::find($value->admin_id)->name;
                $Users[$key]['created_at'] = $value->created_at;
            }
        }
        return view('SuperAdmin.hisobot.guruh_users_minus',compact('Users'));
    }
    public function guruhUsers(){
        $User = User::where('type','User')->get();
        $Users = array();
        foreach ($User as $key => $value) {
            $GuruhUser = count(GuruhUser::where('user_id',$value->id)->where('status','true')->get());
            if($GuruhUser>0){
                $Users[$key]['id'] = $value->id;
                $Users[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $Users[$key]['name'] = $value->name;
                $Users[$key]['addres'] = $value->addres;
                $Users[$key]['tkun'] = $value->tkun;
                $Users[$key]['phone'] = $value->phone;
                $Users[$key]['phone2'] = $value->phone2;
                $Users[$key]['about'] = $value->about;
                $Users[$key]['smm'] = $value->smm;
                $Users[$key]['balans'] = $value->balans;
                $Users[$key]['login'] = $value->email;
                $Users[$key]['guruhlar'] = $GuruhUser;
                $Users[$key]['admin'] = User::find($value->admin_id)->name;
                $Users[$key]['created_at'] = $value->created_at;
            }
        }
        return view('SuperAdmin.hisobot.guruh_users_plus',compact('Users'));
    }
    public function guruhUsers2(){
        $Users = array();
        $GuruhUser = GuruhUser::where('status','true')->get();
        foreach ($GuruhUser as $key => $value) {
                $Users[$key]['id'] = $value->id;
                $Users[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $Users[$key]['name'] = User::find($value->user_id)->name;
                $Users[$key]['addres'] = User::find($value->user_id)->addres;
                $Users[$key]['tkun'] = User::find($value->user_id)->tkun;
                $Users[$key]['phone'] = User::find($value->user_id)->phone;
                $Users[$key]['phone2'] = User::find($value->user_id)->phone2;
                $Users[$key]['smm'] = User::find($value->user_id)->smm;
                $Users[$key]['balans'] = User::find($value->user_id)->balans;
                $Users[$key]['login'] = User::find($value->user_id)->email;
                $Users[$key]['admin'] = User::find($value->admin_id_start)->name;
                $Users[$key]['created_at'] = $value->created_at;
                $Users[$key]['guruh'] = Guruh::find($value->guruh_id)->guruh_name;
        }
        return view('SuperAdmin.hisobot.guruh_users_plus2',compact('Users'));
    }
    public function Tulovlar(){
        $Tulov = Tulov::get();
        $Tulovlar = array();
        foreach ($Tulov as $key => $value) {
            $Tulovlar[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Tulovlar[$key]['name'] = User::find($value->user_id)->name;
            $Tulovlar[$key]['admin'] = User::find($value->admin_id)->name;
            $Tulovlar[$key]['created_at'] = $value->created_at;
            $Tulovlar[$key]['summa'] = $value->summa;
            $Tulovlar[$key]['type'] = $value->type;
            $Tulovlar[$key]['about'] = $value->about;
            if($value->guruh_id==" " OR $value->guruh_id=='NULL'){
                $Tulovlar[$key]['guruh'] = "NULL";
            }else{
                $Tulovlar[$key]['guruh'] = Guruh::where('id',$value->guruh_id)->first()->guruh_name;
            }
        }
        return view('SuperAdmin.hisobot.tulovlar',compact('Tulovlar'));
    }
    public function Chiqimlar(){
        $Moliya = Moliya::where('status','true')->get();
        $CHiqim = array();
        foreach ($Moliya as $key => $value) {
            if($value->xodisa=='Chiqim'){
                $CHiqim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $CHiqim[$key]['xodisa'] = "Kassadan Chiqim";
                $CHiqim[$key]['summa'] = $value->summa;
                $CHiqim[$key]['type'] = $value->type;
                $CHiqim[$key]['about'] = $value->about;
                $CHiqim[$key]['user_id'] = User::find($value->user_id)->name;
                $CHiqim[$key]['admin_id'] = User::find($value->admin_id)->name;
                $CHiqim[$key]['created_at'] = $value->created_at;
            }
            if($value->xodisa=='Qaytarildi'){
                $CHiqim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $CHiqim[$key]['xodisa'] = "Kassaga qaytarildi";
                $CHiqim[$key]['summa'] = $value->summa;
                $CHiqim[$key]['type'] = $value->type;
                $CHiqim[$key]['about'] = $value->about;
                $CHiqim[$key]['user_id'] = User::find($value->user_id)->name;
                $CHiqim[$key]['admin_id'] = User::find($value->admin_id)->name;
                $CHiqim[$key]['created_at'] = $value->created_at;
            }
        }
        return view('SuperAdmin.hisobot.chiqim',compact('CHiqim'));
    }
    public function Xarajatlar(){
        $Moliya = Moliya::where('status','true')->get();
        $CHiqim = array();
        foreach ($Moliya as $key => $value) {
            if($value->xodisa=='XarajatAdmin'){
                $CHiqim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $CHiqim[$key]['xodisa'] = "Admin xarajat";
                $CHiqim[$key]['summa'] = $value->summa;
                $CHiqim[$key]['type'] = $value->type;
                $CHiqim[$key]['about'] = $value->about;
                $CHiqim[$key]['user_id'] = User::find($value->user_id)->name;
                $CHiqim[$key]['admin_id'] = User::find($value->admin_id)->name;
                $CHiqim[$key]['created_at'] = $value->created_at;
            }
            if($value->xodisa=='Xarajat'){
                $CHiqim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $CHiqim[$key]['xodisa'] = "Kassadan xarajat";
                $CHiqim[$key]['summa'] = $value->summa;
                $CHiqim[$key]['type'] = $value->type;
                $CHiqim[$key]['about'] = $value->about;
                $CHiqim[$key]['user_id'] = User::find($value->user_id)->name;
                $CHiqim[$key]['admin_id'] = User::find($value->admin_id)->name;
                $CHiqim[$key]['created_at'] = $value->created_at;
            }
        }
        return view('SuperAdmin.hisobot.xarajat',compact('CHiqim'));
    }
    public function hodimlar(){
        $Hodim = array();
        $User = User::get();
        foreach ($User as $key => $value) {
            if($value->type=='Operator' OR $value->type=="Admin"){
                $Hodim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $Hodim[$key]['fio'] = $value->name;
                $Hodim[$key]['phone'] = $value->phone;
                $Hodim[$key]['phone2'] = $value->phone2;
                $Hodim[$key]['addres'] = $value->addres;
                $Hodim[$key]['tkun'] = $value->tkun;
                $Hodim[$key]['type'] = $value->type;
                $Hodim[$key]['about'] = $value->about;
                $Hodim[$key]['login'] = $value->email;
                $Hodim[$key]['meneger'] = User::find($value->admin_id)->name;
                $Hodim[$key]['created_at'] = $value->created_at;
                $Hodim[$key]['updated_at'] = $value->updated_at;
                if($value->status=='true'){
                    $Hodim[$key]['status'] = "Ishga olingan";
                }else{
                    $Hodim[$key]['status'] = "Ishdan bo'shatilgan";
                }
            }
        }
        return view('SuperAdmin.hisobot.hodim',compact('Hodim'));
    }
    public function techers(){
        $Hodim = array();
        $User = User::get();
        foreach ($User as $key => $value) {
            if($value->type=='Techer'){
                $Hodim[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
                $Hodim[$key]['fio'] = $value->name;
                $Hodim[$key]['phone'] = $value->phone;
                $Hodim[$key]['phone2'] = $value->phone2;
                $Hodim[$key]['addres'] = $value->addres;
                $Hodim[$key]['tkun'] = $value->tkun;
                $Hodim[$key]['type'] = $value->type;
                $Hodim[$key]['about'] = $value->about;
                $Hodim[$key]['login'] = $value->email;
                $Hodim[$key]['meneger'] = User::find($value->admin_id)->name;
                $Hodim[$key]['created_at'] = $value->created_at;
                $Hodim[$key]['updated_at'] = $value->updated_at;
                if($value->status=='true'){
                    $Hodim[$key]['status'] = "Ishga olingan";
                }else{
                    $Hodim[$key]['status'] = "Ishdan bo'shatilgan";
                }
            }
        }
        return view('SuperAdmin.hisobot.techer',compact('Hodim'));
    }
    public function Guruhlar(){
        $Guruh = array();
        foreach (Guruh::get() as $key => $value) {
            $Guruh[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Guruh[$key]['guruh'] = $value->guruh_name;
            $Guruh[$key]['techer'] = User::find($value->techer_id)->name;
            $Guruh[$key]['cours_name'] = Cours::find($value->cours_id)->cours_name;
            $Guruh[$key]['room_name'] = Room::find($value->room_id)->room_name;
            $Guruh[$key]['guruh_price'] = $value->guruh_price;
            $Guruh[$key]['guruh_chegirma'] = $value->guruh_chegirma;
            $Guruh[$key]['guruh_admin_chegirma'] = $value->guruh_admin_chegirma;
            $Guruh[$key]['techer_price'] = $value->techer_price;
            $Guruh[$key]['techer_bonus'] = $value->techer_bonus;
            $Guruh[$key]['guruh_start'] = $value->techer_bonus;
            $Guruh[$key]['guruh_end'] = $value->techer_bonus;
            $Guruh[$key]['meneger'] = User::find($value->admin_id)->name;
        }
        return view('SuperAdmin.hisobot.guruhlar',compact('Guruh'));
    }
    public function HodimIshHaqi(){
        $Pays = array();
        $IshHaqi = IshHaqi::where('status','Hodim')->get();
        foreach ($IshHaqi as $key => $value) {
            $Pays[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Pays[$key]['user'] = User::find($value->user_id)->name;
            $Pays[$key]['admin'] = User::find($value->admin_id)->name;
            $Pays[$key]['about'] = $value->about;
            $Pays[$key]['summa'] = $value->summa;
            $Pays[$key]['type'] = $value->type;
            $Pays[$key]['created_at'] = $value->created_at;
        }
        return view('SuperAdmin.hisobot.hodimPay',compact('Pays'));
    }
    public function TecherIshHaqi(){
        $Pays = array();
        $IshHaqi = IshHaqi::where('status',"!=",'Hodim')->get();
        foreach ($IshHaqi as $key => $value) {
            $Pays[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Pays[$key]['user'] = User::find($value->user_id)->name;
            $Pays[$key]['admin'] = User::find($value->admin_id)->name;
            $Pays[$key]['about'] = $value->about;
            $Pays[$key]['summa'] = $value->summa;
            $Pays[$key]['type'] = $value->type;
            $Pays[$key]['created_at'] = $value->created_at;
        }
        return view('SuperAdmin.hisobot.techerPay',compact('Pays'));
    }
    public function TestNatija(){
        $Test = array();
        $TestNatija = TestNatija::get();
        foreach ($TestNatija as $key => $value) {
            $Test[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Test[$key]['guruh'] = Guruh::find($value->guruh_id)->guruh_name;
            $Test[$key]['user'] = Guruh::find($value->user_id)->name;
            $Test[$key]['savollar'] =$value->savol_count;
            $Test[$key]['tugri_count'] =$value->tugri_count;
            $Test[$key]['notugri_count'] =$value->notugri_count;
            $Test[$key]['ball'] =$value->ball;
            $Test[$key]['created_at'] =$value->created_at;
        }
        return view('SuperAdmin.hisobot.test_natija',compact('Test'));
    }
    public function UmumiyBalansTarixi(){
        $Test = array();
        $Balanss = Moliya::get();
        $Balans = array();
        foreach ($Balanss as $key => $value) {
            $Balans[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Balans[$key]['xodisa'] = $value->xodisa;
            $Balans[$key]['summa'] = $value->summa;
            $Balans[$key]['type'] = $value->type;
            $Balans[$key]['about'] = $value->about;
            $Balans[$key]['about'] = $value->about;
            $Balans[$key]['user_id'] = User::find($value->user_id)->name;
            $Balans[$key]['created_at'] = $value->created_at;
        }
        return view('SuperAdmin.hisobot.balans',compact('Balans'));
    }
    public function show(Request $request){
        $type = $request->report;
        if($type=='all_tashrif'){return $this->Tashriflar();}
        if($type=='debet_users'){return $this->Qarzdorlar();}
        if($type=='guruh_minus_users'){return $this->guruhNoUsers();}
        if($type=='guruh_plus_users'){return $this->guruhUsers();}
        if($type=='guruh_plus_users2'){return $this->guruhUsers2();}
        if($type=='pay'){return $this->Tulovlar();}
        if($type=='chiqimlar'){return $this->Chiqimlar();}
        if($type=='xarajatlar'){return $this->Xarajatlar();}
        if($type=='hodimlar'){return $this->hodimlar();}
        if($type=='techer'){return $this->techers();}
        if($type=='guruhlar'){return $this->Guruhlar();}
        if($type=='hodim_ish_haqi'){return $this->HodimIshHaqi();}
        if($type=='techer_ish_haqi'){return $this->TecherIshHaqi();}
        if($type=='test_natija'){return $this->TestNatija();}
        if($type=='umumiy_balans_tarixi'){return $this->UmumiyBalansTarixi();}
        dd($type);

        #return view('SuperAdmin.hisobot.show');
    }
}
