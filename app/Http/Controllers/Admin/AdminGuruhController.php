<?php

namespace App\Http\Controllers\Admin;
use App\Models\TulovSetting;
use App\Models\Room;
use App\Models\User;
use App\Models\Filial;
use App\Models\Davomat;
use App\Models\Guruh;
use App\Models\TestNatija;
use App\Models\UserHistory;
use App\Models\GuruhUser;
use App\Models\SmsCounter;
use App\Models\Cours;
use App\Models\GuruhTime;
use App\Models\IshHaqi;
use App\Models\SendMessege;
use App\Models\Text;
use App\Events\debitSendMessege;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class AdminGuruhController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $EndData = date("Y-m-d",strtotime('-15 day',strtotime(date('Y-m-d'))));
        $Guruh = Guruh::where('filial_id',request()->cookie('filial_id'))
            ->where('guruh_end','>=',$EndData)->orderby('guruh_start','desc')->get();
        $Guruhlar = array();
        foreach($Guruh as $key=> $item){
            $Guruhlar[$key]['guruh_name'] = $item->guruh_name;
            $Guruhlar[$key]['guruh_start'] = $item->guruh_start;
            $Guruhlar[$key]['guruh_end'] = $item->guruh_end;
            if($item->guruh_start<=date("Y-m-d") AND $item->guruh_end>=date("Y-m-d")){
                $Guruhlar[$key]['guruh'] = 0;
            }elseif($item->guruh_start>date("Y-m-d")){
                $Guruhlar[$key]['guruh'] = 1;
            }else{
                $Guruhlar[$key]['guruh'] = -1;
            } 
            $GuruhUser = count(GuruhUser::where('guruh_id',$item->id)->where('status','true')->get());
            $Guruhlar[$key]['talabalar'] = $GuruhUser;
            $Guruhlar[$key]['id'] = $item->id;
        }
        return view('Admin.guruh.index',compact('Guruhlar'));
    } 
    public function endGuruh(){
        $EndData = date("Y-m-d");
        $Guruh = Guruh::where('filial_id',request()->cookie('filial_id'))->where('guruh_end','<',$EndData)->get();
        $Guruhlar = array();
        foreach($Guruh as $key=> $item){
            $Guruhlar[$key]['guruh_name'] = $item->guruh_name;
            $Guruhlar[$key]['guruh_start'] = $item->guruh_start;
            $Guruhlar[$key]['guruh_end'] = $item->guruh_end;
            if($item->guruh_start<=date("Y-m-d") AND $item->guruh_end>=date("Y-m-d")){
                $Guruhlar[$key]['guruh'] = 0;
            }elseif($item->guruh_start>date("Y-m-d")){
                $Guruhlar[$key]['guruh'] = 1;
            }else{
                $Guruhlar[$key]['guruh'] = -1;
            }
            $GuruhUser = count(GuruhUser::where('guruh_id',$item->id)->where('status','true')->get());
            $Guruhlar[$key]['talabalar'] = $GuruhUser;
            $Guruhlar[$key]['id'] = $item->id;
        }
        return view('Admin.guruh.end',compact('Guruhlar'));
    }
    public function CreateGuruh(){
        $TulovSetting = TulovSetting::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        $Room = Room::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        $Techer = User::where('filial_id',request()->cookie('filial_id'))->where('status','true')->where('type','Techer')->get();
        $Cours = Cours::where('filial_id',request()->cookie('filial_id'))->where('created_at','!=',null)->get();
        return view('Admin.guruh.create',compact('TulovSetting','Room','Techer','Cours'));
    }
    public function DarsKunlari($StartData, $type){
        $startTimestamp = strtotime($StartData);
        $endTimestamp = strtotime('+31 day',$startTimestamp);
        $i = 1;
        if($type=='toq'){
            $Juft = [1, 3, 5];
        }elseif($type=='juft'){
            $Juft = [2, 4, 6];
        }else{
            $Juft = [1, 2, 3, 4, 5, 6];
        }
        $dates = array();
        while ($startTimestamp <= $endTimestamp) {
            $currentDayOfWeek = date('N', $startTimestamp);
            if (in_array($currentDayOfWeek, $Juft)) { // Monday, Wednesday, Friday
                if($type=='xarkuni'){
                    if($i==25){break;}
                }else{
                    if($i==14){break;}
                }
                $dates[] = date('Y-m-d', $startTimestamp);
                $i = $i+1;
            }
            $startTimestamp = strtotime('+1 day', $startTimestamp);
        }
        return $dates;
    }
    public function boshSoatlar($dars_vaqti){
        $Mavjud_vaqtlar = array();
        foreach($dars_vaqti as $teme){
            switch ($teme) {
                case 1:
                    $Mavjud_vaqtlar['1']['text'] = '08:00-09:30';
                    $Mavjud_vaqtlar['1']['id'] = 1;
                    break;
                case 2:
                    $Mavjud_vaqtlar['2']['text'] = '09:30-11:00';
                    $Mavjud_vaqtlar['2']['id'] = 2;
                    break;
                case 3:
                    $Mavjud_vaqtlar['3']['text'] = '11:00-12:30';
                    $Mavjud_vaqtlar['3']['id'] = 3;
                break;
                case 4:
                    $Mavjud_vaqtlar['4']['text'] = '12:30-14:00';
                    $Mavjud_vaqtlar['4']['id'] = 4;
                    break;
                case 5:
                    $Mavjud_vaqtlar['5']['text'] = '14:00-15:30';
                    $Mavjud_vaqtlar['5']['id'] = 5;
                    break;
                case 6:
                    $Mavjud_vaqtlar['6']['text'] = '15:30-17:00';
                    $Mavjud_vaqtlar['6']['id'] = 6;
                    break;
                case 7:
                    $Mavjud_vaqtlar['7']['text'] = '17:00-18:30';
                    $Mavjud_vaqtlar['7']['id'] = 7;
                    break;
                case 8:
                    $Mavjud_vaqtlar['8']['text'] = '18:30-20:00';
                    $Mavjud_vaqtlar['8']['id'] = 7;
                    break;
                case 9:
                    $Mavjud_vaqtlar['9']['text'] = '20:00-21:30';
                    $Mavjud_vaqtlar['9']['id'] = 7;
                    break;
            }
        }
        return $Mavjud_vaqtlar;
    }
    public function CreateGuruh1(Request $request){
        $validate = $request->validate([
            'guruh_name' => ['required', 'string', 'max:255'],
            'guruh_price' => ['required', 'string', 'max:255'],
            'guruh_start' => ['required', 'string', 'max:255'],
            'hafta_kun' => ['required', 'string', 'max:255'],
            'room_id' => ['required', 'string', 'max:255'],
            'techer_id' => ['required', 'string', 'max:255'],
            'techer_price' => ['required', 'string', 'max:255'],
            'techer_bonus' => ['required', 'string', 'max:255'],
            'cours_id' => ['required', 'string', 'max:255']
        ]);
        if($request->guruh_start < date('Y-m-d')){return redirect()->back()->with('error', 'Guruhni bugungi kun va kiyingi kunlarda ochish mumkun.'); }
        $dars_kunlari = $this->DarsKunlari($request->guruh_start,$request->hafta_kun);
        $TulovSetting = TulovSetting::where('id',$request->guruh_price)->where('status','true')->first();
        $dars_vaqti = array(1,2,3,4,5,6,7,8,9);
        foreach ($dars_vaqti as $value) {
            $K = 0;
            foreach($dars_kunlari as $item){
                $GuruhJadval = GuruhTime::where('room_id',$request->room_id)
                ->where('dates',$item)
                ->where('times',$value)->get();
                if(count($GuruhJadval)>0){
                    $K++;
                }
            }
            if($K>0){
                unset($dars_vaqti[$value-1]);
            }
        }
        $GuruhView = array();
        $GuruhView['guruh_name'] = strtoupper($request->guruh_name);
        $GuruhView['guruh_price'] = number_format(($TulovSetting->tulov_summa), 0, '.', ' ');
        $GuruhView['guruh_techer'] = User::find($request->techer_id)->name;
        $GuruhView['techer_price'] = str_replace(","," ",$request->techer_price);
        $GuruhView['techer_bonus'] = str_replace(","," ",$request->techer_bonus);
        $GuruhView['cours'] = Cours::find($request->cours_id)->cours_name;
        $GuruhView['room'] = Room::find($request->room_id)->room_name;
        $GuruhView['hafta_kun'] = $request->hafta_kun;
        $GuruhView['guruh_start'] = $request->guruh_start;
        $GuruhView['guruh_end'] = end($dars_kunlari);
        $GuruhView['count_day'] = count($dars_kunlari);
        $GuruhView['kunlar'] = $dars_kunlari;
        $GuruhView['dars_vaqtlari'] = $this->boshSoatlar($dars_vaqti);
        $GuruhInput = array();

        $GuruhInput['filial_id'] = request()->cookie('filial_id');
        $GuruhInput['techer_id'] = $request->techer_id;
        $GuruhInput['cours_id'] = $request->cours_id;
        $GuruhInput['room_id'] = $request->room_id;
        $GuruhInput['guruh_name'] = $request->guruh_name;
        $GuruhInput['guruh_price'] = $TulovSetting->tulov_summa;
        $GuruhInput['guruh_chegirma'] = $TulovSetting->chegirma;
        $GuruhInput['guruh_admin_chegirma'] = $TulovSetting->admin_chegirma;
        $GuruhInput['techer_price'] = str_replace(",","",$request->techer_price);
        $GuruhInput['techer_bonus'] = str_replace(",","",$request->techer_bonus);
        $GuruhInput['guruh_status'] = 'true';
        $GuruhInput['guruh_start'] = $request->guruh_start;
        $GuruhInput['guruh_end'] = end($dars_kunlari);
        return view('Admin.guruh.create2',compact('GuruhView','GuruhInput'));
    }
    public function CreateGuruh2(Request $request){
        $validate = $request->validate([
            'filial_id' => ['required'],
            'techer_id' => ['required'],
            'cours_id' => ['required'],
            'room_id' => ['required'],
            'guruh_name' => ['required'],
            'guruh_price' => ['required'],
            'guruh_chegirma' => ['required'],
            'guruh_admin_chegirma' => ['required'],
            'techer_price' => ['required'],
            'techer_bonus' => ['required'],
            'guruh_status' => ['required'],
            'guruh_start' => ['required'],
            'guruh_end' => ['required'],
            'guruh_vaqt' => ['required'],
        ]);
        $validate['admin_id'] = Auth::user()->id;
        $validate['guruh_name'] = strtoupper($request->guruh_name);
        $Guruh = Guruh::create($validate);
        $GuruhID = $Guruh->id;
        $Kunlar = array();
        $Kunlar['date0'] = $request->date0;
        $Kunlar['date1'] = $request->date1;
        $Kunlar['date2'] = $request->date2;
        $Kunlar['date3'] = $request->date3;
        $Kunlar['date4'] = $request->date4;
        $Kunlar['date5'] = $request->date5;
        $Kunlar['date6'] = $request->date6;
        $Kunlar['date7'] = $request->date7;
        $Kunlar['date8'] = $request->date8;
        $Kunlar['date9'] = $request->date9;
        $Kunlar['date10'] = $request->date10;
        $Kunlar['date11'] = $request->date11;
        $Kunlar['date12'] = $request->date12;
        if($request->count_day==24){
            $Kunlar['date13'] = $request->date13;
            $Kunlar['date14'] = $request->date14;
            $Kunlar['date15'] = $request->date15;
            $Kunlar['date16'] = $request->date16;
            $Kunlar['date17'] = $request->date17;
            $Kunlar['date18'] = $request->date18;
            $Kunlar['date19'] = $request->date19;
            $Kunlar['date20'] = $request->date20;
            $Kunlar['date21'] = $request->date21;
            $Kunlar['date22'] = $request->date22;
            $Kunlar['date23'] = $request->date23;
        }
        foreach ($Kunlar as $key12 => $valueTTTT) {
            GuruhTime::create([
                'filial_id'=>$request->filial_id,
                'room_id'=>$request->room_id,
                'guruh_id'=>$GuruhID,
                'dates'=>$valueTTTT,
                'times'=>$request->guruh_vaqt,
            ]);
        }
        return redirect()->route('AdminGuruhShow',$Guruh->id); 
    }
    public function GuruhAbout($id){ 
        $Guruhlar = Guruh::find($id);
        $Guruh = array();
        $Guruh['guruh_name'] = $Guruhlar->guruh_name;
        $Guruh['guruh_price'] = number_format(($Guruhlar->guruh_price), 0, '.', ' ');
        $Guruh['techer_price'] = number_format(($Guruhlar->techer_price), 0, '.', ' ');
        $Guruh['techer_bonus'] = number_format(($Guruhlar->techer_bonus), 0, '.', ' ');
        $Guruh['guruh_start'] = $Guruhlar->guruh_start;
        $Guruh['guruh_end'] = $Guruhlar->guruh_end;
        $Guruh['guruh_vaqt'] = $Guruhlar->guruh_vaqt;
        $Guruh['admin_id'] = User::find($Guruhlar->admin_id)->email;
        $Guruh['techer_id'] = User::find($Guruhlar->techer_id)->name;
        $Guruh['techer_techer'] = $Guruhlar->techer_id;
        $Guruh['created_at'] = $Guruhlar->created_at;
        $Guruh['updated_at'] = $Guruhlar->updated_at;
        $Guruh['cours_id'] = Cours::find($Guruhlar->cours_id)->cours_name;
        $Guruh['cours_cours'] = $Guruhlar->cours_id;
        $Guruh['room_id'] = Room::find($Guruhlar->room_id)->room_name;
        $Guruh['id'] = $Guruhlar->id;
        switch ($Guruhlar->guruh_vaqt) {
            case 1:
                $Guruh['guruh_vaqt'] = '08:00-09:30';
                break;
            case 2:
                $Guruh['guruh_vaqt'] = '09:30-11:00';
                break;
            case 3:
                $Guruh['guruh_vaqt'] = '11:00-12:30';
            break;
            case 4:
                $Guruh['guruh_vaqt'] = '12:30-14:00';
                break;
            case 5:
                $Guruh['guruh_vaqt'] = '14:00-15:30';
                break;
            case 6:
                $Guruh['guruh_vaqt'] = '15:30-17:00';
                break;
            case 7:
                $Guruh['guruh_vaqt'] = '17:00-18:30';
                break;
            case 8:
                $Guruh['guruh_vaqt'] = '18:30-20:00';
                break;
            case 9:
                $Guruh['guruh_vaqt'] = '20:00-21:30';
                break;
        }
        $Kunlar = GuruhTime::where('guruh_id',$Guruhlar->id)->get();
        $Kun = array();
        foreach ($Kunlar as $key => $value) {
            $Kun[$key] = $value->dates;
        }
        $Guruh['Kunlar'] = $Kun;
        return $Guruh;
    }
    public function userEndGroups($id){
        $GuruhUser = GuruhUser::where('guruh_id',$id)->where('status','true')->get();
        $Deletes = array();
        $Users = array();
        foreach ($GuruhUser as $key => $value) {
            $Users[$key]['user_id'] = $value->user_id;
            $Users[$key]['user_name'] = User::where('id',$value->user_id)->first()->name;
        }
        $Deletes['user'] = $Users;
        $Deletes['guruh_price'] = number_format((Guruh::where('id',$id)->first()->guruh_price), 0, '.', ' ');
        return $Deletes;
    }
    public function guruhTalabalari($guruh_id){
        $GuruhUser = GuruhUser::where('guruh_id',$guruh_id)->orderby('id','desc')->get();
        $Users = array();
        foreach ($GuruhUser as $key => $value) {
            $Users[$key]['user_id'] = $value->user_id;
            $Users[$key]['User'] = User::find($value->user_id)->name;
            $Users[$key]['commit_start'] = $value->commit_start;
            $Users[$key]['created_at'] = $value->created_at;
            $Users[$key]['admin_id_start'] = User::find($value->admin_id_start)->email;
            if($value->status=='true'){
                $Users[$key]['commit_end'] = " ";
                $Users[$key]['admin_id_end'] = " ";
                $Users[$key]['updated_at'] = " ";
                $Users[$key]['status'] = "Faol";
            }else{
                $Users[$key]['commit_end'] = $value->commit_end;
                $Users[$key]['admin_id_end'] = User::find($value->admin_id_end)->email;
                $Users[$key]['updated_at'] = $value->updated_at;
                $Users[$key]['status'] = "O'chirildi";
            }
            $Users[$key]['balans'] = number_format((User::find($value->user_id)->balans), 0, '.', ' ');
        }
        return $Users;
    }
    public function show($id){
        $Guruh = $this->GuruhAbout($id);
        $DarsKunlari = count($Guruh['Kunlar']);
        $Days = GuruhTime::where('guruh_id',$Guruh['id'])->get();
        $guruhlar = Cours::where('filial_id',request()->cookie('filial_id'))->get();
        $TulovSetting = TulovSetting::where('filial_id',request()->cookie('filial_id'))->where('status','=','true')->get();
        $Room = Room::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        $UsersDeletes = $this->userEndGroups($id);
        $Talabalar = $this->guruhTalabalari($id);
        $Guruhw['kunlar'] = GuruhTime::where('guruh_id',$id)->get();
        $Davomat = array();
        foreach (GuruhUser::where('guruh_id',$id)->where('status','true')->get() as $key => $value) {
            $Davomat[$key]['name'] = User::find($value->user_id)->name;
            foreach (GuruhTime::where('guruh_id',$id)->get() as $key2 => $item) {
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
        $Techers = User::where('filial_id',request()->cookie('filial_id'))->where('type','Techer')->where('status','true')->get();
        return view('Admin.guruh.show',compact('guruhlar','Techers','Natija','DarsKunlari','Davomat','Guruhw','TulovSetting','Room','Guruh','Days','UsersDeletes','Talabalar'));
    }
    public function showUpdatestGuruh(Request $request){
        $validate = $request->validate([
            'guruh_name' => ['required'],
            'guruh_price' => ['required'],
            'techer_id' => ['required'],
            'techer_price' => ['required'],
            'techer_bonus' => ['required']
        ]);
        $validate['guruh_price'] = str_replace(" ","",str_replace(",","",$request->guruh_price));
        $validate['techer_price'] = str_replace(" ","",str_replace(",","",$request->techer_price));
        $validate['techer_bonus'] = str_replace(" ","",str_replace(",","",$request->techer_bonus));
        $Guruh = Guruh::find($request->id);
        $Guruh->update($validate);
        return redirect()->back()->with('success', "Guruh yangilandi.");
    }
    public function guruhDelUser(Request $request){
        $validate = $request->validate([
            'guruh_id' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'string', 'max:255'],
            'commit_end' => ['required', 'string', 'max:255']
        ]);
        $jarima = str_replace(",","",$request->jarima);
        $validate['status'] = 'false';
        $validate['admin_id_end'] = Auth::User()->id;
        $UserGuruh = GuruhUser::where('user_id',$validate['user_id'])->where('guruh_id',$validate['guruh_id'])->where('status','true')->first();
        $UserGuruh->update($validate);
        $User = User::find($request->user_id);
        $Balans = $User->balans;
        $Guruh_name = Guruh::where('id',$request->guruh_id)->first()->guruh_name;
        $Guruh_price = Guruh::where('id',$request->guruh_id)->first()->guruh_price;
        $Xisob = strval($Balans." + ".$Guruh_price." = ".$Balans+$Guruh_price);
        $Balans = $Balans+$Guruh_price;
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$request->user_id,
            'status'=>"Guruhdan o'chirildi",
            'type'=>$Guruh_name."( ".$request->commit_end." )",
            'summa'=>$Guruh_price,
            'xisoblash'=>$Xisob,
            'balans'=>$Balans,
        ]);
        $Xisob2 = strval($Balans." - ".$jarima." = ".$Balans-$jarima);
        $Balans = $Balans-$jarima;
        $UserHistory = UserHistory::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$request->user_id,
            'status'=>"Jarima",
            'type'=>$Guruh_name."( ".$request->commit_end." )",
            'summa'=>$jarima,
            'xisoblash'=>$Xisob2,
            'balans'=>$Balans,
        ]);
        $Users = User::find($request->user_id)->update([
            'balans'=>$Balans
        ]);
        $User_name = $User->name;
        return redirect()->back()->with('success', $User_name.' guruhdan o\'chirildi.'); 
    }
    public function userSendMessege(Request $request){
        $GuruhUser = GuruhUser::where('guruh_id',$request->guruh_id)->where('status','true')->get();
        $Users = array();
        foreach ($GuruhUser as $key => $value) {
            $Userss = strval('User'.$value->user_id);
            if($request->$Userss){
                $Phone = User::find($value->user_id)->phone;
                $Users[$key] = "+998".str_replace(" ","",$Phone);
            }
        }
        $Text = $request->text;
        $k=0;
        foreach ($Users as $key => $value) {
            $eskiz_email = env('ESKIZ_UZ_EMAIL');
            $eskiz_password = env('ESKIZ_UZ_Password');
            $eskiz = new Eskiz($eskiz_email,$eskiz_password);
            $eskiz->requestAuthLogin();
            $from='4546';
            $mobile_phone = $value;
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
            $k++;
            $SmsCounter = SmsCounter::find(1);
            $SmsCounter->maxsms = $SmsCounter->maxsms - 1;
            $SmsCounter->counte = $SmsCounter->counte + 1;
            $SmsCounter->save();
            
            SendMessege::create([
                'phone'=> $value,
                'text'=> strval($Text),
                'status'=>"Yuborildi"
            ]);
        }
        return redirect()->back()->with('success', $k.' ta talabaga sms xabar yuborildi.');
    }
    public function debitSendMessege(Request $request){
        $UserGuruh = GuruhUser::where('guruh_id',$request->guruh_id)->where('status','true')->get();
        $Messege = array();
        $FIlial = Filial::find(request()->cookie('filial_id'))->filial_name;
        $k=0;
        foreach ($UserGuruh as $key => $value) {
            $User = User::find($value->user_id);
            if($User->balans<0){
                $Messege[$key]['name'] = $User->name;
                $Messege[$key]['qarz'] = $User->balans*(-1);
                $Messege[$key]['phone'] = "+998".str_replace(" ","",$User->phone);
                $k++;
            }
        }
        if($k>0){
            debitSendMessege::dispatch($Messege,$FIlial);
        }
        return redirect()->back()->with('success', $k.' ta qarzdor talabaga sms xabar yuborildi.');
    }
    public function CreateGuruhNext(Request $request){
        if($request->dars_boshlanish_vaqti<date("Y-m-d")){
            return redirect()->back()->with('error', 'Yangi guruhni bugungi kungacha bo\'lgan kunlar bilan ochish mumkun emas.');
        }
        $Guruh = Guruh::find($request->guruh_id);
        $NewGuruhForm = array();
        $NewGuruhForm['filial_id'] = request()->cookie('filial_id');
        $NewGuruhForm['techer_id'] = $request->techer_id;
        $NewGuruhForm['cours_id'] = $request->cours_id;
        $NewGuruhForm['room_id'] = $request->room_id;
        $NewGuruhForm['guruh_name'] = $request->guruh_name;
        $NewGuruhForm['guruh_price'] = TulovSetting::find($request->guruh_price)->tulov_summa;
        $NewGuruhForm['guruh_chegirma'] = TulovSetting::find($request->guruh_price)->chegirma;
        $NewGuruhForm['guruh_admin_chegirma'] = TulovSetting::find($request->guruh_price)->admin_chegirma;
        $NewGuruhForm['techer_price'] = intval(str_replace(",","",$request->techer_price));
        $NewGuruhForm['techer_bonus'] = intval(str_replace(",","",$request->techer_bonus));
        $NewGuruhForm['guruh_status'] = 'true';
        $NewGuruhForm['guruh_start'] = $request->dars_boshlanish_vaqti;
        $NewGuruhForm['admin_id'] = Auth::user()->id;
        $NewGuruh = array();
        $NewGuruh['guruh_name'] = $request->guruh_name;
        $NewGuruh['guruh_price'] = TulovSetting::find($request->guruh_price)->tulov_summa;
        $NewGuruh['techer_id'] = User::find($request->techer_id)->name;
        $NewGuruh['techer_price'] = $request->techer_price;
        $NewGuruh['techer_bonus'] = $request->techer_bonus;
        $NewGuruh['cours_id'] = Cours::find($request->cours_id)->cours_name;
        $NewGuruh['room_id'] = Room::find($request->room_id)->room_name;
        $NewGuruh['guruh_start'] = $request->dars_boshlanish_vaqti;
        $NewGuruh['dars_kunlari'] = $this->DarsKunlari($request->dars_boshlanish_vaqti,$request->hafta_kuni);
        $NewGuruh['guruh_end'] = end($NewGuruh['dars_kunlari']);
        $NewGuruh['count_kun'] = count($NewGuruh['dars_kunlari']);
        $NewGuruh['hafta_kuni'] = $request->hafta_kuni;
        $NewGuruh['users'] = GuruhUser::where('guruh_users.guruh_id',$request->guruh_id)->where('guruh_users.status','true')->join('users','users.id','guruh_users.user_id')->select('users.id','users.name')->get();
        $dars_vaqti = array(1,2,3,4,5,6,7,8,9);
        foreach ($dars_vaqti as $value) {
            $K = 0;
            foreach($NewGuruh['dars_kunlari'] as $item){
                $GuruhJadval = GuruhTime::where('room_id',$request->room_id)
                ->where('dates',$item)
                ->where('times',$value)->get();
                if(count($GuruhJadval)>0){
                    $K++;
                }
            }
            if($K>0){
                unset($dars_vaqti[$value-1]);
            }
        }
        $NewGuruh['bosh_vaqtlar'] = $this->boshSoatlar($dars_vaqti);
        return view('Admin.guruh.create_next',compact('Guruh','NewGuruh','NewGuruhForm'));
    }
    public function CreateGuruhNext2(Request $request){
        $DarsKunlari = array();
        $DarsKunlari['0'] = $request->kun0;
        $DarsKunlari['1'] = $request->kun1;
        $DarsKunlari['2'] = $request->kun2;
        $DarsKunlari['3'] = $request->kun3;
        $DarsKunlari['4'] = $request->kun4;
        $DarsKunlari['5'] = $request->kun5;
        $DarsKunlari['6'] = $request->kun6;
        $DarsKunlari['7'] = $request->kun7;
        $DarsKunlari['8'] = $request->kun8;
        $DarsKunlari['9'] = $request->kun9;
        $DarsKunlari['10'] = $request->kun10;
        $DarsKunlari['11'] = $request->kun11;
        $DarsKunlari['12'] = $request->kun12;
        if($request->count_kun==24){
            $DarsKunlari['13'] = $request->kun12;
            $DarsKunlari['14'] = $request->kun12;
            $DarsKunlari['15'] = $request->kun12;
            $DarsKunlari['16'] = $request->kun12;
            $DarsKunlari['17'] = $request->kun12;
            $DarsKunlari['18'] = $request->kun12;
            $DarsKunlari['19'] = $request->kun12;
            $DarsKunlari['20'] = $request->kun12;
            $DarsKunlari['21'] = $request->kun12;
            $DarsKunlari['22'] = $request->kun12;
            $DarsKunlari['23'] = $request->kun12;
        }
        $validate = $request->validate([
            'techer_id' => ['required', 'string', 'max:255'],
            'cours_id' => ['required', 'string', 'max:255'],
            'room_id' => ['required', 'string', 'max:255'],
            'guruh_name' => ['required', 'string', 'max:255'],
            'guruh_price' => ['required', 'string', 'max:255'],
            'guruh_chegirma' => ['required', 'string', 'max:255'],
            'guruh_admin_chegirma' => ['required', 'string', 'max:255'],
            'techer_price' => ['required', 'string', 'max:255'],
            'techer_bonus' => ['required', 'string', 'max:255'],
            'guruh_status' => ['required', 'string', 'max:255'],
            'guruh_start' => ['required', 'string', 'max:255'],
            'guruh_end' => ['required', 'string', 'max:255'],
            'guruh_vaqt' => ['required', 'string', 'max:255'],
        ]);
        $validate['guruh_name'] = strtoupper($request->guruh_name);
        $validate['admin_id'] = Auth::User()->id;
        $validate['filial_id'] = request()->cookie('filial_id');
        $Guruh = Guruh::create($validate);
        $filial_id = $Guruh->filial_id;
        $guruh_id = $Guruh->id;
        $room_id = $Guruh->room_id;
        $times = $Guruh->guruh_vaqt;
        foreach ($DarsKunlari as $key => $value) {
            $GuruhTime = GuruhTime::create([
                'filial_id'=>$filial_id,
                'guruh_id'=>$guruh_id,
                'room_id'=>$room_id,
                'dates'=>$value,
                'times'=>$times,
            ]);
        }
        $admin_id_start = $Guruh->admin_id;
        $commit_start = "Yangi guruhga ko'chirildi.";
        $status = "true";
        $GuruhUser = GuruhUser::where('guruh_id',$request->guruh_id)->where('status','true')->get();
        foreach ($GuruhUser as $key => $value) {
            $Userss = strval('User'.$value->user_id);
            if($request->$Userss){
                GuruhUser::create([
                    'filial_id'=>$filial_id,
                    'user_id'=>$value->user_id,
                    'guruh_id'=>$guruh_id,
                    'status'=>$status,
                    'commit_start'=>$commit_start,
                    'admin_id_start'=>$admin_id_start,
                ]);
                $Users = User::find($value->user_id);
                $Balans = $Users->balans;
                $Qoldiq = $Balans-$Guruh->guruh_price;
                $Users->balans = $Qoldiq;
                $Users->save();
                $UserHistory = UserHistory::create([
                    'filial_id'=>request()->cookie('filial_id'),
                    'user_id'=>$value->user_id,
                    'status'=>"Guruhga qo'shildi",
                    'type'=>$Guruh->guruh_name,
                    'summa'=>$Guruh->guruh_price,
                    'xisoblash'=>$Balans."-".$Guruh->guruh_price."=".$Qoldiq,
                    'balans'=>$Qoldiq,
                ]);
            }
        }
        return redirect()->route('AdminGuruhShow',$guruh_id)->with('success', 'Yangi guruh ochildi.');
    }
    public function deletGuruh(Request $request){
        $GuruhUser = count(GuruhUser::where('guruh_id',$request->guruh_id)->get());
        if($GuruhUser>0){
            return redirect()->back()->with('error', "Guruhga talabalar mavjud guruhni o'chirish mumkun emas."); 
        }
        $IshHaqi = count(IshHaqi::where('status',$request->guruh_id)->get());
        if($IshHaqi>0){
            return redirect()->back()->with('error', "Guruh uchun o'qituvchiga ish haqi to'langan guruhni o'chirish mumkun emas."); 
        }
        $Guruh = Guruh::find($request->guruh_id);
        $Guruh->delete();
        $GuruhTime = GuruhTime::where('guruh_id',$request->guruh_id)->get();
        foreach ($GuruhTime as $key => $value) {
            $value->delete();
        }
        return redirect()->route('AdminGuruh')->with('success', "Guruh o'chirildi."); 
    }
    

}
