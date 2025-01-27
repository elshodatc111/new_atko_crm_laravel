<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\Filial;
use App\Models\FilialKassa;
use App\Models\Moliya;
use App\Models\User;
use App\Models\MavjudIshHaqi;
use Illuminate\Support\Facades\Auth;;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperMoliyaController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function xarajat(Request $request){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        if($request->summa==0){
            return redirect()->back()->with('error', 'Xarajat summasi noto\'g\'ri.'); 
        }
        $filial_id = $request->filial_id;
        $Filial = Filial::find($filial_id);
        $summa = str_replace(",","",$request->summa);
        $type = $request->type;
        if($type=='Naqt'){
            $Mavjud = $Filial->naqt;
            if($summa>$Mavjud){
                return redirect()->back()->with('error', 'Filail balansida yetarli mablag\' mavjud emas.'); 
            }
            $Filial->naqt = $Filial->naqt - $summa;
            $Filial->xarajat_naqt = $Filial->xarajat_naqt + $summa;
        }elseif ($type=='Plastik') {
             $Mavkud = $Filial->plastik; 
             if($Mavkud<$summa){
                 return redirect()->back()->with('error', 'Filail balansida yetarli mablag\' mavjud emas.'); 
             }
             $Filial->plastik = $Filial->plastik - $summa;
             $Filial->xarajat_plastik = $Filial->xarajat_plastik + $summa;
        }elseif($type=="Payme"){
             $Mavkud = $Filial->payme; 
             if($Mavkud<$summa){
                 return redirect()->back()->with('error', 'Filail balansida yetarli mablag\' mavjud emas.'); 
             }
             $Filial->payme = $Filial->payme - $summa;
             $Filial->xarajat_payme = $Filial->xarajat_payme + $summa;
        }
        $Filial->save();
        Moliya::create([
            'filial_id'=>$filial_id,
            'xodisa'=>"XarajatAdmin",
            'summa'=>$summa,
            'type'=>$type,
            'status'=>'true',
            'about'=>$request->about,
            'user_id'=>Auth::User()->id,
            'admin_id'=>Auth::User()->id,
        ]);
        return redirect()->back()->with('success', 'Xarajatlar uchun chiqim qilindi.'); 
    }

    public function kassaga(Request $request){
        if($request->summa==0){
            return redirect()->back()->with('error', 'Filialqa qaytarish summasi noto\'g\'ri.'); 
        }
        $filial_id = $request->filial_id;
        $filial_id2 = $request->filial_id2;
        $Filial = Filial::find($filial_id);
        $summa = str_replace(",","",$request->summa);

        $type = $request->type;

        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',$filial_id2)->first();

        if($type=='Naqt'){
            $Mavjud = $Filial->naqt;
            if($summa>$Mavjud){
                return redirect()->back()->with('error', 'Filail balansida yetarli mablag\' mavjud emas.'); 
            }
            $MavjudIshHaqi->naqt = $MavjudIshHaqi->naqt + $summa;
            $Filial->naqt = $Filial->naqt - $summa;
            $Filial->xarajat_naqt = $Filial->xarajat_naqt + $summa;
        }elseif ($type=='Plastik') {
             $Mavkud = $Filial->plastik; 
             if($Mavkud<$summa){
                 return redirect()->back()->with('error', 'Filail balansida yetarli mablag\' mavjud emas.'); 
             }
             $MavjudIshHaqi->plastik = $MavjudIshHaqi->plastik + $summa;
             $Filial->plastik = $Filial->plastik - $summa;
             $Filial->xarajat_plastik = $Filial->xarajat_plastik + $summa;
        }
        $MavjudIshHaqi->save();
        $Filial->save();
        Moliya::create([
            'filial_id'=>$filial_id,
            'xodisa'=>"Qaytarildi",
            'summa'=>$summa,
            'type'=>$type,
            'status'=>'true',
            'about'=>$request->about,
            'user_id'=>Auth::User()->id,
            'admin_id'=>Auth::User()->id,
        ]);
        return redirect()->back()->with('success', 'Filial balansiga qaytarildi.'); 
    }
}
