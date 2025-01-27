<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\AdminKassa;
use App\Models\FilialKassa;
use App\Models\IshHaqi;
use App\Models\MavjudIshHaqi;
use App\Events\CreateHodim;
use App\Events\CreatIshHaqi;
use App\Events\HodimUpdatePasswor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HodimController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function adminHodimlar(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator'){
            auth()->logout();
            return redirect()->route('login');
        }
        $User = User::where('filial_id',request()->cookie('filial_id'))->where('type','!=','SuperAdmin')->where('type','!=','User')->where('type','!=','Techer')->where('status','true')->get();
        return view('Admin.hodimlar',compact('User'));
    }
    public function adminCreateHodimlar(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users']
        ]);
        $parol = 12345678;
        $validate['status'] = 'true';
        $validate['admin_id'] = Auth::User()->id;
        $validate['password'] = Hash::make($parol);
        $validate['filial_id'] = request()->cookie('filial_id');
        $User = User::create($validate);
        CreateHodim::dispatch($User->id); 
        return redirect()->back()->with('success', 'Yangi hodim qo\'shildi.'); 
    }
    public function adminHodimDelete($id){
        $User = User::find($id);
        $User->status = 'false';
        $User->save();
        return redirect()->route('adminHodimlar')->with('success', 'Hodim o\'chirildi.'); 
    }
    public function adminHodim($id){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator'){
            auth()->logout();
            return redirect()->route('login');
        }
        $User = User::find($id);
        $Kassa = array();
        $AdminKassa = AdminKassa::where('user_id',$id)->first();
        $Kassa['naqt'] = number_format(($AdminKassa->naqt), 0, '.', ' ');
        $Kassa['plastik'] = number_format(($AdminKassa->plastik), 0, '.', ' ');
        $Kassa['chegirma'] = number_format(($AdminKassa->chegirma), 0, '.', ' ');
        $Kassa['qaytarildi'] = number_format(($AdminKassa->qaytarildi), 0, '.', ' ');
        $Kassa['tashriflar'] = number_format(($AdminKassa->tashriflar), 0, '.', ' ');
        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',request()->cookie('filial_id'))->first();
        $Kassa['MavjudNaqt'] = number_format($MavjudIshHaqi->naqt, 0, '.', ' ');
        $Kassa['MavjudPlastik'] = number_format($MavjudIshHaqi->plastik, 0, '.', ' ');
        $ishHaqi = array();
        $Days2 = date("Y-m-d h:i:s",strtotime('-35 day',time()));
        foreach(IshHaqi::where('user_id',$id)->where('created_at','>=',$Days2)->orderby('id','desc')->get() as $key=> $item){
            $ishHaqi[$key]['id']=$item->id;
            $ishHaqi[$key]['summa']=number_format(($item->summa), 0, '.', ' ');
            $ishHaqi[$key]['type']=$item->type;
            $ishHaqi[$key]['about']=$item->about;
            $ishHaqi[$key]['created_at']=$item->created_at;
            $ishHaqi[$key]['admin_email']=User::find($item->admin_id)->email;
        }
        return view('Admin.hodim_show',compact('User','Kassa','ishHaqi'));
    }
    public function adminClearHodimlarStatistik(Request $request){
        $AdminKassa = AdminKassa::where('user_id',$request->user_id)->first();
        $AdminKassa->naqt = 0;
        $AdminKassa->plastik = 0;
        $AdminKassa->chegirma = 0;
        $AdminKassa->qaytarildi = 0;
        $AdminKassa->tashriflar = 0;
        $AdminKassa->save();
        return redirect()->back()->with('success', 'Statistika tozalandi.'); 
    }
    public function adminUpdateHodimlarUser(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
        ]);
        $User = User::find($request->user_id);
        $User->update($validate);
        return redirect()->back()->with('success', 'Hodim taxrirlandi.'); 
    }
    public function adminUpdateHodimlarPassword(Request $request){
        $User = User::find($request->user_id);
        $password = rand(10000000, 99999999);
        $User->password = Hash::make($password);
        $User->save();
        HodimUpdatePasswor::dispatch($User->id,$password);
        return redirect()->back()->with('success', 'Parol yangilandi.'); 
    }
    public function adminPayHodimlarIshHaqi(Request $request){
        if($request->type == 'Naqt'){
            $Mavjud = str_replace(" ","",$request->Naqt);
        }else{
            $Mavjud = str_replace(" ","",$request->Plastik);
        }
        $summa = str_replace(",","",$request->summa);
        $filial_id = request()->cookie('filial_id');
        $type = $request->type;
        if($Mavjud<$summa){
            return redirect()->back()->with('error', 'Kassada yetarli mablag\' emas.');
        }
        $IshHaqi = IshHaqi::create([
            'user_id' => $request->user_id,
            'summa' => $summa,
            'type' => $type,
            'about' => $request->about,
            'admin_id' =>  Auth::user()->id,
            'status' => "Hodim",
            'filial_id' => $filial_id,
        ]);
        CreatIshHaqi::dispatch($type,$summa,$filial_id);
        return redirect()->back()->with('success', 'Hodimga ish haqi to\'landi.'); 
    }
}
