<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Guruh;
use App\Models\Eslatma;
use App\Models\SendMessege;
use App\Models\TulovDelete;
use App\Models\SmsCounter;
use App\Models\AdminKassa;
use App\Models\UserHistory;
use App\Models\GuruhUser;
use App\Models\ChegirmaDay;
use App\Models\FilialKassa;
use App\Models\Tulov;
use App\Events\CreateTashrif;
use App\Events\createTulov;
use App\Events\UserResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
use Illuminate\Support\Facades\Http;

class AdminStudentController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Users = User::where('filial_id',request()->cookie('filial_id'))->where('type','User')->orderby('id','desc')->get();
        $User = array();
        foreach ($Users as $key => $value) {
            $User[$key]['id']=$value->id;
            $User[$key]['name']=$value->name; 
            $User[$key]['addres']=$value->addres;
            $User[$key]['phone']=$value->phone;
            $GuruhUser = count(GuruhUser::where('user_id',$value->id)->where('status','true')->get());
            $User[$key]['guruhlar']=$GuruhUser;
            $User[$key]['created_at']=$value->created_at;
        }
        return view('Admin.user.index',compact('User'));
    }
    public function debit(){
        $User = User::where('filial_id',request()->cookie('filial_id'))->where('type','User')->orderby('id','desc')->where('balans','<',0)->get();
        return view('Admin.user.debit',compact('User'));
    }
    public function pays(){
        $Tulov = Tulov::where('filial_id',request()->cookie('filial_id'))->orderby('id','desc')->get();
        $pays = array();
        foreach ($Tulov as $key => $value) {
            $pays[$key]['id'] = $value->id;
            $pays[$key]['user_id'] = User::find($value->user_id)->id;
            $pays[$key]['fio'] = User::find($value->user_id)->name;
            if($value->guruh_id!='NULL' OR $value->guruh_id!=" "){
                $pays[$key]['guruh'] = " ";
            }else{
                $pays[$key]['guruh'] = Guruh::where('id',$value->guruh_id)->guruh_name;
            }
            $pays[$key]['type'] = $value->type;
            $pays[$key]['about'] = $value->about;
            $pays[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $pays[$key]['meneger'] = User::find($value->admin_id)->email;
            $pays[$key]['created_at'] = $value->created_at;
        }
        return view('Admin.user.pays',compact('pays'));
    }
    public function create(){
        return view('Admin.user.create');
    }
    public function store(Request $request){
        $login = rand(1,9);
        $password = rand(10000000,99999999);
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'smm' => ['required', 'string', 'max:255']
        ]);
        $validate['filial_id'] = request()->cookie('filial_id');
        $validate['type'] = 'User';
        $validate['name'] = strtoupper($request->name);
        $validate['status'] = 'true';
        $validate['balans'] = null;
        $validate['email'] = time()*$login;
        $validate['password'] = Hash::make($password);
        $validate['admin_id'] = Auth::user()->id;
        $Users = count(User::where('filial_id',$validate['filial_id'])->where('phone',$validate['phone'])->where('type','User')->get());
        if($Users>0){
            return redirect()->back()->with('error', 'Siz kiritgan telegon raqam oldin ro\'yhatga olingan.'); 
        }
        $NewUser = User::create($validate);
        $id = $NewUser->id;
        $Phone = str_replace(" ","",$NewUser->phone);
        $UserHistory = UserHistory::create([
            'filial_id' => $validate['filial_id'],
            'user_id' => $id,
            'status' => 'Markazga tashrif',
            'balans' => 0,
        ]);
        CreateTashrif::dispatch($id,$Phone,$password);
        return redirect()->route('Student')->with('success', 'Yangi tashrif qo\'shildi.'); 
    }
    public function guruhPlus(Request $request){
        $validate = $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'guruh_id' => ['required', 'string', 'max:255'],
            'commit_start' => ['required', 'string', 'max:255'],
        ]);
        $validate['filial_id'] = request()->cookie('filial_id');
        $validate['status'] = 'true';
        $validate['admin_id_start'] = Auth::user()->id;
        $GuruhUser2 = GuruhUser::where('user_id',$request->user_id)->where('guruh_id',$request->guruh_id)->where('status','true')->get();
        if(count($GuruhUser2)>0){
            return redirect()->back()->with('error', 'Talaba siz tanlagan guruhda mavjud.'); 
        }
        $GuruhUser = GuruhUser::create($validate);
        $Guruh = Guruh::where('id',$request->guruh_id)->first();
        $Guruh_price = $Guruh->guruh_price;
        $Balans = User::where('id',$request->user_id)->first()->balans;
        if(empty($Balans)){
            $Balans = 0;
        }
        $Summa = $Balans-$Guruh_price;
        $User = User::find($request->user_id);
        $User->update(['balans'=>$Summa]);
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$request->user_id,
            'status'=>"Guruhga qo'shildi",
            'type'=>$Guruh->guruh_name,
            'summa'=>-$Guruh_price,
            'xisoblash'=>$Balans."-".$Guruh_price."=".$Summa,
            'balans'=>$Summa
        ]);
        return redirect()->back()->with('success', 'Talaba yangi guruhga qo\'shildi.'); 
    }
    public function update(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255']
        ]);
        $User = User::find($request->user_id)->update($validate);
        return redirect()->back()->with('success', 'Talaba malumotlari yangilandi.'); 
    }
    public function userAbout($id){
        $User = User::find($id);
        $Users = array();
        $Users['id'] = $User->id;
        $Users['name'] = $User->name;
        $Users['phone'] = $User->phone;
        $Users['phone2'] = $User->phone2;
        $Users['addres'] = $User->addres;
        $Users['tkun'] = $User->tkun;
        $Users['balans'] = number_format(($User->balans), 0, '.', ' ');
        $Users['about'] = $User->about;
        $Users['smm'] = $User->smm;
        $Users['email'] = $User->email;
        return $Users;
    }
    public function passwordUpdate(Request $request){
        $password = rand(10000000,99999999);
        $User = User::find($request->id);
        $User->password = Hash::make($password);
        $User->save();
        UserResetPassword::dispatch($User->name,$password,$User->phone);
        return redirect()->back()->with('success', 'Talaba paroli yangilandi.'); 
    }
    public function sendMessege(Request $request){
        $User = User::find($request->user_id);
        $phone = "+998".str_replace(" ","",$User->phone);
        $Text = $request->text;
        $eskiz_email = env('ESKIZ_UZ_EMAIL');
        $eskiz_password = env('ESKIZ_UZ_Password');
        $eskiz = new Eskiz($eskiz_email,$eskiz_password);
        $eskiz->requestAuthLogin();
        $from='4546';
        $mobile_phone = $phone;
        $message = $Text;
        $user_sms_id = 1;
        $callback_url = '';
        $singleSmsType = new SmsSingleSmsType(
            from: $from,
            message: $message,
            mobile_phone: $mobile_phone,
            user_sms_id:$user_sms_id,
            callback_url:$callback_url
        );
        $result = $eskiz->requestSmsSend($singleSmsType);
        $SmsCounter = SmsCounter::find(1);
        $SmsCounter->maxsms = $SmsCounter->maxsms - 1;
        $SmsCounter->counte = $SmsCounter->counte + 1;
        $SmsCounter->save();
        SendMessege::create([
            'phone'=> $phone,
            'text'=> strval($Text),
            'status'=>"Yuborildi"
        ]);
        return redirect()->back()->with('success', 'SMS xabar yuborildi.'); 
    }
    public function Guruhs($id){
        $Guruhs = Guruh::where('guruh_end','>',date('Y-m-d'))->orderby('guruh_name','asc')->where('filial_id',request()->cookie('filial_id'))->get();
        $Guruh = array();
        foreach ($Guruhs as $key => $value) {
            $GuruhUser = count(GuruhUser::where('user_id',$id)
                ->where('guruh_id',$value->id)
                ->where('status','true')->get());
            if($GuruhUser==0){
                $Guruh[$key]['guruh_id'] = $value->id;
                $Guruh[$key]['guruh_start'] = $value->guruh_start;
                $Guruh[$key]['guruh_name'] = $value->guruh_name;
                $Guruh[$key]['techer'] = User::find($value->techer_id)->name;
            }
        }
        return $Guruh;
    }
    public function userHistory($id){
        $UserHistory = UserHistory::where('user_id',$id)->orderby('id','desc')->get();
        $Keys = array();
        foreach ($UserHistory as $key => $value) {
            $Keys[$key]['filial_id'] = $value->filial_id;
            $Keys[$key]['user_id'] = $value->user_id;
            $Keys[$key]['status'] = $value->status;
            $Keys[$key]['type'] = $value->type;
            $Keys[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Keys[$key]['xisoblash'] = $value->xisoblash;
            $Keys[$key]['balans'] = number_format(($value->balans), 0, '.', ' ');
        }
        return $UserHistory;
    }
    public function TalabaGuruhlari($id){
        $GuruhUser = GuruhUser::where('user_id',$id)->get();
        $result = array();
        foreach($GuruhUser as $key => $item){
            $result[$key]['guruh_name'] = Guruh::where('id',$item->guruh_id)->first()->guruh_name;
        }
    }
    public function userArxivGuruh($id){
        $userArxivGuruh = GuruhUser::where('user_id',$id)->get();
        $History = array();
        foreach($userArxivGuruh as $key => $item){
            $History[$key]['id'] = $item->id;
            $History[$key]['guruh_id'] = $item->guruh_id;
            $History[$key]['guruh_name'] = Guruh::find($item->guruh_id)->guruh_name;
            $History[$key]['guruh_starts'] = Guruh::find($item->guruh_id)->guruh_start;
            $History[$key]['guruh_start'] = $item->created_at;
            $History[$key]['commit_start'] = $item->commit_start;
            $History[$key]['admin_id_start'] = User::where('id',$item->admin_id_start)->first()->email;
            $History[$key]['status'] = $item->status;
            if($item->status=='true'){
                $History[$key]['admin_id_end'] = " ";
                $History[$key]['updated_at'] = " ";
                $History[$key]['commit_end'] = " ";
            }else{
                $History[$key]['commit_end'] = $item->commit_end;
                $History[$key]['admin_id_end'] = User::where('id',$item->admin_id_end)->first()->email;
                $History[$key]['updated_at'] = $item->updated_at;
            }
        }
        return $History;
    }
    public function chegirmaliGuruhlar($id){
        $userArxivGuruh = GuruhUser::where('user_id',$id)->where('status','true')->get();
        $ChegirmaDay = ChegirmaDay::where('filial_id',request()->cookie('filial_id'))->first()->days;
        $ChegirmaDays = date("Y-m-d",strtotime('-'.$ChegirmaDay.' day',strtotime(date('Y-m-d'))));
        $Guruhlar = array();
        foreach ($userArxivGuruh as $key => $value) {
            $Guruh = Guruh::where('id',$value->guruh_id)->where('guruh_start','>=',$ChegirmaDays)->first();
            if($Guruh){
                $Tulovs = count(Tulov::where('user_id',$id)
                    ->where('guruh_id',$value->guruh_id)
                    ->where('type','Chegirma')->get());
                if($Tulovs>0){}
                else{
                    $Guruhlar[$key]['guruh_id'] = $Guruh->id;
                    $Guruhlar[$key]['guruh_name'] = $Guruh->guruh_name;
                    $Guruhlar[$key]['chegirmaTulov'] = $Guruh->guruh_price-$Guruh->guruh_chegirma;
                }
            }
        }
        return $Guruhlar;
    }
    public function TalabaTulovlari($id){
        $TalabaTulovlar = Tulov::where('user_id',$id)->get();
        $Tulov = array();
        foreach ($TalabaTulovlar as $key => $value) {
            $Tulov[$key]['id'] = $value->id;
            $Tulov[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Tulov[$key]['type'] = $value->type;
            $Tulov[$key]['about'] = $value->about;
            $Tulov[$key]['created_at'] = $value->created_at;
            $Tulov[$key]['admin'] = User::find($value->admin_id)->email;
        }
        return $Tulov;
    }
    public function adminChegirma($id){
        $userArxivGuruh = GuruhUser::where('user_id',$id)->where('status','true')->get();
        $Guruhlar = array();
        $thsDay = date("Y-m-d");
        foreach ($userArxivGuruh as $key => $value) {
            $guruh_id = $value->guruh_id;
            $Guruh = Guruh::where('id',$guruh_id)->where('guruh_end','>=',$thsDay)->first();
            if($Guruh){
                $Tulovs = count(Tulov::where('user_id',$id)->where('guruh_id',$value->guruh_id)->where('type','Chegirma')->get());
                if($Tulovs>0){}
                else{
                    $Guruhlar[$key]['id'] = $value->guruh_id;
                    $Guruhlar[$key]['guruh_name'] = $Guruh->guruh_name;
                    $Guruhlar[$key]['max_chegirma'] = $Guruh->guruh_admin_chegirma;
                }
            }
        }
        return $Guruhlar;
    }
    public function kassadaMavjud(){
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        $Kassa = array();
        $Kassa['naqt'] = number_format(($FilialKassa->tulov_naqt), 0, '.', ' ');
        $Kassa['plastik'] = number_format(($FilialKassa->tulov_plastik), 0, '.', ' ');
        return $Kassa;
    }
    public function show($id){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Users = $this->userAbout($id);
        $Guruhs = $this->Guruhs($id);
        $userHistory = $this->userHistory($id);
        $talaba_guruh = $this->TalabaGuruhlari($id);
        $userArxivGuruh = $this->userArxivGuruh($id);
        $ChegirmaGuruh = $this->chegirmaliGuruhlar($id);
        $Tulovlar = $this->TalabaTulovlari($id);
        $adminChegirma = $this->adminChegirma($id);
        $FilialKassa = $this->kassadaMavjud();
        $Eslatma = Eslatma::where('type','user')->where('user_guruh_id',$id)->orderby('id','desc')->get();
        $eslat = array();
        foreach ($Eslatma as $key => $value) {
            $eslat[$key]['id'] = $value->id;
            $eslat[$key]['text'] = $value->text;
            $eslat[$key]['status'] = $value->status;
            $eslat[$key]['admin_id'] = User::find($value->admin_id)->email;
            $eslat[$key]['created_at'] = $value->created_at;
        }
        $Balans2 = User::find($id)->balans;
        $email = intval(User::find($id)->email);
        $Balans3 = number_format($Balans2, 2, '.', ' ');
        return view('Admin.user.show',compact('Balans3','eslat','FilialKassa','adminChegirma','Users','Guruhs','userHistory','Tulovlar','talaba_guruh','userArxivGuruh','ChegirmaGuruh'));
    }
    public function tulov(Request $request){ 
        $validate = $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'naqt' => ['required', 'string', 'max:255'],
            'plastik' => ['required', 'string', 'max:255']
        ]);
        if($request->naqt == '0' AND $request->plastik == '0'){
            return redirect()->back()->with('error', 'To\'lov summasi noto\'g\'ri kiritildi.'); 
        }
        createTulov::dispatch($request->user_id, $request->naqt, $request->plastik, $request->guruh_id, $request->about);
        return redirect()->back()->with('success', 'To\'lov amalga oshirildi.'); 
    }
    public function tulovDelete($id){
        $TalabaTulovlar = Tulov::where('id',$id)->first();
        $user_id = $TalabaTulovlar->user_id;
        $guruh_id = $TalabaTulovlar->guruh_id;
        if($guruh_id=='NULL'){
            $guruh_name = " ";
        }else{
            $guruh_name = Guruh::where('id',$guruh_id)->first()->guruh_name;
        }
        $summa = $TalabaTulovlar->summa;
        $type = $TalabaTulovlar->type;
        if($type=='Payme'){
            return redirect()->back()->with('error', 'Payme orqali to\'lovni o\'chirib bo\'lmaydi.'); 
        }
        if($type=='Qaytarildi (Plastik)'){
            return redirect()->back()->with('error', 'Qaytarilgan to\'lovni o\'chirib bo\'lmaydi.'); 
        }
        if($type=='Qaytarildi (Naqt)'){
            return redirect()->back()->with('error', 'Qaytarilgan to\'lovni o\'chirib bo\'lmaydi.'); 
        }
        if($TalabaTulovlar->created_at<=date("Y-m-d")." 00:00:00"){
            return redirect()->back()->with('error', 'To\'lovni o\'chirish muddati 1 kun To\'lov o\'chirilmadi.'); 
        }
        TulovDelete::create([
            'filial_id'=>$TalabaTulovlar->filial_id,
            'user_id'=>$TalabaTulovlar->user_id,
            'summa'=>$TalabaTulovlar->summa,
            'type'=>$TalabaTulovlar->type,
            'admin_id'=>Auth::user()->id,
        ]);
        $User = User::find($user_id);
        $User_Balans = $User->balans;
        $User_balans = $User->balans;
        $User->balans = $User_balans-$summa;
        $User->save();
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($type=='Chegirma'){
            if(empty($FilialKassa->tulov_chegirma)){
                $TypeChegirma = 0;
            }else{
                $TypeChegirma = $FilialKassa->tulov_chegirma;
            }
            $FilialKassa->tulov_chegirma = $TypeChegirma-$summa; 
        }elseif($type='Naqt'){
            $FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt-$summa;        
        }elseif($type='Plastik'){
            $FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik-$summa;            
        }
        $FilialKassa->save();
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$user_id,
            'status'=>"To'lov o'chirildi(".$TalabaTulovlar->type.")",
            'type'=>$guruh_name,
            'summa'=>$summa,
            'xisoblash'=>$User_Balans."-".$summa."=".$User->balans,
            'balans'=>$User->balans
        ]);
        $TalabaTulovlar->delete();
        return redirect()->back()->with('success', 'To\'lov o\'chirildi.'); 
    }
    public function adminChegirmaMax(Request $request){
        if($request->chegirma==0){
            return redirect()->back()->with('error', 'Chegirma summasi noto\'g\'ri.'); 
        }
        $guruh_id = $request->guruh_id;
        $user_id = $request->user_id;
        $User = User::find($user_id);
        $Chegirma = str_replace(",","", $request->chegirma);
        $Guruh = Guruh::find($guruh_id);
        if($Guruh->guruh_admin_chegirma<$Chegirma){
            return redirect()->back()->with('error', 'Guruh uchun chegirma maksimal so\'mmadan ortib ketdi.'); 
        }
        $about = $request->about;
        $Guruh_Name = $Guruh->guruh_name;
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$user_id,
            'status'=>'Chegirma',
            'type'=>$Guruh_Name,
            'summa'=>$Chegirma,
            'xisoblash'=>$User->balans."+".$Chegirma."=".$User->balans+$Chegirma,
            'balans'=>$User->balans+$Chegirma
        ]);
        $User->balans = $User->balans+$Chegirma;
        $User->save();
        $Tulov = Tulov::create([
            'filial_id' => request()->cookie('filial_id'),
            'user_id' => $user_id,
            'guruh_id' => $guruh_id,
            'summa' => $Chegirma,
            'type' => 'Chegirma',
            'status' => 'true',
            'about' => $about,
            'admin_id' => Auth::user()->id,
        ]);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        $tulov_chegirma = $FilialKassa->tulov_chegirma;
        $Mavjud = $tulov_chegirma + $Chegirma;
        $FilialKassa->tulov_chegirma=$Mavjud;
        $FilialKassa->save();
        return redirect()->back()->with('success', 'Chegirma kiritildi.'); 
    }
    public function tulovQaytar(Request $request){
        $summa = intval(str_replace(",","",$request->summa));
        if($request->type=='Naqt'){
            $naqt = intval(str_replace(" ","",$request->naqt));
            if($summa>$naqt){
                return redirect()->back()->with('error', 'To\'lov qaytarish uchun kassada mablag\' yetarli emas.'); 
            }
        }elseif($request->type=='Plastik'){
            $naqt = intval(str_replace(" ","",$request->plastik));
            if($summa>$naqt){
                return redirect()->back()->with('error', 'To\'lov qaytarish uchun kassada mablag\' yetarli emas.'); 
            }
        }
        if($summa==0){
            return redirect()->back()->with('error', 'To\'lov summasi noto\'g\'ri kiritildi.'); 
        }
        $User = User::find($request->id);
        $Balans = $User->balans;
        $User->balans = $Balans-$summa;
        $User->save();
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$request->id,
            'status'=>'Qaytarildi ('.$request->type.")",
            'type'=>" ",
            'summa'=>$summa,
            'xisoblash'=>$Balans."-".$summa."=".$Balans-$summa,
            'balans'=>$Balans-$summa
        ]);
        $Tulov = Tulov::create([
            'filial_id' => request()->cookie('filial_id'),
            'user_id' => $request->id,
            'guruh_id' => " ",
            'summa' => $summa,
            'type' => 'Qaytarildi ('.$request->type.")",
            'status' => 'true',
            'about' => $request->about,
            'admin_id' => Auth::user()->id,
        ]);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($request->type=='Naqt'){
            $tulov_naqt = $FilialKassa->tulov_naqt;
            $Qoldiq = $tulov_naqt-$summa;
            $FilialKassa->tulov_naqt = $Qoldiq;
        }else{
            $tulov_plastik = $FilialKassa->tulov_plastik;
            $Qoldiq = $tulov_plastik-$summa;
            $FilialKassa->tulov_plastik = $Qoldiq;
        }
        $FilialKassa->save();
        return redirect()->back()->with('success', 'To\'lov qaytarildi.'); 
    }
    public function comment(Request $request){
        Eslatma::create([
            'filial_id'=>request()->cookie('filial_id'),
            'type'=>$request->type,
            'user_guruh_id'=>$request->user_guruh_id,
            'text'=>$request->text,
            'status'=>'true',
            'admin_id'=>Auth::User()->id,
        ]);
        return redirect()->back()->with('success', "Eslatma saqlandi."); 
    }

}
