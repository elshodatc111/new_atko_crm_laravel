<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\FilialKassa;
use App\Models\IshHaqi;
use App\Models\Guruh;
use App\Models\GuruhUser;
use App\Models\GuruhTime;
use App\Models\Davomat;
use App\Models\MavjudIshHaqi;
use App\Events\AdminCreateTecher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\HodimUpdatePasswor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminTecherController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Techers = User::where('filial_id',request()->cookie('filial_id'))->where('type','Techer')->where('status','true')->get();
        return view('Admin.techer.index',compact('Techers'));
    }
    public function index2(){
        $Techers = User::where('filial_id',request()->cookie('filial_id'))->where('type','Techer')->where('status','false')->get();
        return view('Admin.techer.index2',compact('Techers'));
    }
    public function techerCreate(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users']
        ]);
        $password = rand(10000000, 99999999);
        $validate['password'] = Hash::make($password);
        $validate['type'] = 'Techer';
        $validate['status'] = 'true';
        $validate['admin_id'] = Auth::user()->id;
        $validate['filial_id'] = request()->cookie('filial_id');
        $User = User::create($validate);
        AdminCreateTecher::dispatch($User->id,$password);
        return redirect()->back()->with('success', 'Yangi o\'qituvchi qo\'shildi.'); 
    }
    public function techerShow($id){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Techer = User::find($id);
        $Days = date("Y-m-d",strtotime('-30 day',time()));
        $Days2 = date("Y-m-d h:i:s",strtotime('-35 day',time()));
        $Guruhlar = Guruh::where('techer_id',$id)->where('guruh_status','true')->where('guruh_end','>=',$Days)->get();
        $Guruh = array();
        $Statistika = array();
        $newGuruh = 0;
        $activGuruh = 0;
        $endGuruh = 0;
        foreach ($Guruhlar as $key => $value) {
            $TecherTulov = $value->techer_price;
            $TecherBonus = $value->techer_bonus;
            if($value->guruh_start>date("Y-m-d")){$newGuruh = $newGuruh + 1;
            }elseif($value->guruh_end<date("Y-m-d")){$endGuruh = $endGuruh + 1;
            }else{$activGuruh = $activGuruh + 1;}
            $tulov = 0;
            $IshHaqi = IshHaqi::where('user_id',$id)->where('status',$value->id)->get();
            foreach ($IshHaqi as $items) {$tulov = $tulov + $items->summa;}
            $bonuss = 0;
            $Student = GuruhUser::where('guruh_id',$value->id)->where('status','true')->get();
            foreach ($Student as $talaba) {
                $BonusTalaba = count(GuruhUser::where('user_id',$talaba->user_id)->where('created_at','>=',$talaba->created_at)->where('status','true')->get());
                if($BonusTalaba>1){$bonuss = $bonuss + 1;}
            } 
            $AllGroupsUserCount = count(GuruhUser::where('guruh_id',$value->id)->where('status','true')->get());
            $Guruh[$key]['id'] = $value->id;
            $Guruh[$key]['guruh_name'] = $value->guruh_name;
            $Guruh[$key]['guruh_start'] = $value->guruh_start;
            $Guruh[$key]['guruh_end'] = $value->guruh_end;
            $Guruh[$key]['Users'] = $AllGroupsUserCount;
            $Guruh[$key]['Bonus'] = $bonuss;
            $Guruh[$key]['delete'] = count(GuruhUser::where('guruh_id',$value->id)->where('status','false')->get());
            $GuruhTime = GuruhTime::where('guruh_id',$value->id)->get();
            $CountDavomat = 0;
            foreach ($GuruhTime as $guruh_time) {
                $dates = $guruh_time->dates;
                $Davomat = count(Davomat::where('guruh_id',$value->id)->where('dates',$dates)->get());
                if($Davomat>0){
                    $CountDavomat = $CountDavomat + 1;
                }
            }
            if(count($GuruhTime)==0){
                $TecherTulov = $TecherTulov*0*$Guruh[$key]['Users']*$CountDavomat;
            }else{
                $TecherTulov = $TecherTulov/12*$Guruh[$key]['Users']*$CountDavomat;
            }
            
            $TecherBonus = $TecherBonus*$bonuss;
            $TecherTulovlarga = $AllGroupsUserCount*$value->techer_price;
            $Guruh[$key]['Davomat'] = $CountDavomat;
            $Guruh[$key]['Hisoblandi'] = number_format($TecherTulov + $TecherBonus, 0, '.', ' ');
            $Guruh[$key]['Tulov'] = number_format($tulov, 0, '.', ' ');
            $Guruh[$key]['AllTulov'] = number_format($TecherTulovlarga+$TecherBonus, 0, '.', ' ');
        }
        $Statistika['new'] = $newGuruh;
        $Statistika['activ'] = $activGuruh;
        $Statistika['end'] = $endGuruh;

        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',request()->cookie('filial_id'))->first();
        $Statistika['Naqt'] = number_format($MavjudIshHaqi->naqt, 0, '.', ' ');
        $Statistika['Plastik'] = number_format($MavjudIshHaqi->plastik, 0, '.', ' ');
        $Tulovlar = IshHaqi::where('user_id',$id)->where('created_at','>=',$Days2)->orderby('id','desc')->get();
        $Tulov = array();
        foreach ($Tulovlar as $key => $value) {
            $Tulov[$key]['id'] = $value->id;
            $Tulov[$key]['guruh'] = Guruh::find($value->status)->guruh_name;
            $Tulov[$key]['summa'] = number_format($value->summa, 0, '.', ' ');
            $Tulov[$key]['created_at'] = $value->created_at;
            $Tulov[$key]['about'] = $value->about;
            $Tulov[$key]['type'] = $value->type;
            $Tulov[$key]['admin_id'] = User::find($value->admin_id)->email;
        }
        $Time1 = Date("Y-m-d")." 00:00:00";
        return view('Admin.techer.show',compact('Time1','Techer','Guruh','Statistika','Tulov'));
    }
    public function TecherPayDelet($id){
        $IshHaqi = IshHaqi::find($id);
        $FilialKassa = FilialKassa::where('filial_id',$IshHaqi->filial_id)->first();
        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',request()->cookie('filial_id'))->first();
        if($IshHaqi->type=='Naqt'){
            $MavjudIshHaqi->naqt = $MavjudIshHaqi->naqt+$IshHaqi->summa;
            #$FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt+$IshHaqi->summa;
            $FilialKassa->tulov_naqt_ish_haqi = $FilialKassa->tulov_naqt_ish_haqi-$IshHaqi->summa;
        }else{
            $MavjudIshHaqi->plastik = $MavjudIshHaqi->plastik+$IshHaqi->summa;
            #$FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik+$IshHaqi->summa;
            $FilialKassa->tulov_plastik_ish_haqi = $FilialKassa->tulov_plastik_ish_haqi-$IshHaqi->summa;
        }
        $MavjudIshHaqi->save();
        #$FilialKassa->save();
        $IshHaqi->delete();
        return redirect()->back()->with('success', 'O\'qituvchiga to\'lov o\'chirildi.'); 
    }
    public function techerDelete($id){
        $Techer = User::find($id);
        $Techer->status = 'false';
        $Techer->save();
        return redirect()->route('AdminTecher')->with('success', 'O\'qituvchi O\'chirildi.'); 
    }
    public function techerReset($id){
        $Techer = User::find($id);
        $Techer->status = 'true';
        $Techer->save();
        return redirect()->route('AdminTecher')->with('success', 'O\'qituvchi qaytadan tiklandi.'); 
    }
    public function techerUpdate(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
        ]);
        $User = User::find($request->user_id);
        $User->update($validate);
        return redirect()->back()->with('success', 'O\'qituvchi malumotlari yangilandi.'); 
    }
    public function techerUpdatePassword(Request $request){
        $User = User::find($request->user_id);
        $password = rand(10000000, 99999999);
        $User->password = Hash::make($password);
        $User->save();
        HodimUpdatePasswor::dispatch($User->id,$password);
        return redirect()->back()->with('success', 'O\'qituvchi paroli yangilandi.'); 
    }
    public function TecherPay(Request $request){
        $Naqt = str_replace(" ","",$request->Naqt);
        $Plastik = str_replace(" ","",$request->Plastik);
        $summa = str_replace(",","",$request->summa);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',request()->cookie('filial_id'))->first();
        if($summa==0){return redirect()->back()->with('error', 'To\'lov summasi noto\'g\'ri.');}
        if($request->type=='Naqt'){
            if($summa>$Naqt){return redirect()->back()->with('error', 'Kassada mablag\' yetarli emas.'); }
            $MavjudIshHaqi->naqt = $MavjudIshHaqi->naqt-$summa;
            $FilialKassa->tulov_naqt_ish_haqi = $FilialKassa->tulov_naqt_ish_haqi+$summa;
        }else{
            if($summa>$Plastik){return redirect()->back()->with('error', 'Kassada mablag\' yetarli emas.'); }  
            $MavjudIshHaqi->plastik = $MavjudIshHaqi->plastik-$summa;
            $FilialKassa->tulov_plastik_ish_haqi = $FilialKassa->tulov_plastik_ish_haqi+$summa;
        }
        $MavjudIshHaqi->save();
        $FilialKassa->save();
        $IshHaqi = IshHaqi::create([
            'filial_id'=>request()->cookie('filial_id'),
            'user_id'=>$request->user_id,
            'summa'=>$summa,
            'type'=>$request->type,
            'status'=>$request->guruh_id,
            'about'=>$request->about,
            'admin_id'=>Auth::user()->id,
        ]);
        return redirect()->back()->with('success', "O'qituvchiga ish haqi to'landi");
    }
}
