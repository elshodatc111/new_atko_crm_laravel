<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\FilialKassa;
use App\Models\Filial;
use App\Models\Moliya;
use App\Models\MavjudIshHaqi;
use App\Models\Tulov;
use App\Models\TulovDelete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoliyaController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        $Kassa = array();
        $Kassa['Naqt'] = number_format(($FilialKassa->tulov_naqt), 0, '.', ' ');
        $Kassa['Plastik'] = number_format(($FilialKassa->tulov_plastik), 0, '.', ' ');
        $Kassa['ChiqimNaqt'] = number_format(($FilialKassa->tulov_naqt_chiqim), 0, '.', ' ');
        $Kassa['ChiqimPlastik'] = number_format(($FilialKassa->tulov_plastik_chiqim), 0, '.', ' ');
        $Kassa['XarajatNaqt'] = number_format(($FilialKassa->tulov_naqt_xarajat), 0, '.', ' ');
        $Kassa['XarajatPlastik'] = number_format(($FilialKassa->tulov_plastik_xarajat), 0, '.', ' ');
        $Chiqimlar = Moliya::where('filial_id',request()->cookie('filial_id'))->where('xodisa','Chiqim')->where('status','false')->get();
        $Chiqim = array();
        foreach ($Chiqimlar as $key => $value) {
            $Chiqim[$key]['id'] = $value->id;
            $Chiqim[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Chiqim[$key]['type'] = $value->type;
            $Chiqim[$key]['about'] = $value->about;
            $Chiqim[$key]['created_at'] = $value->created_at;
            $Chiqim[$key]['user'] = User::find($value->user_id)->email;
        }
        $Xarajatlar = Moliya::where('filial_id',request()->cookie('filial_id'))->where('xodisa','Xarajat')->where('status','false')->get();
        $Xarajat = array();
        foreach ($Xarajatlar as $key => $value) {
            $Xarajat[$key]['id'] = $value->id;
            $Xarajat[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Xarajat[$key]['type'] = $value->type;
            $Xarajat[$key]['about'] = $value->about;
            $Xarajat[$key]['created_at'] = $value->created_at;
            $Xarajat[$key]['user'] = User::find($value->user_id)->email;
        }
        $Days = date('Y-m-d',strtotime('-7 day', time()))." 00:00:00";
        $JamiTulov = Tulov::where('filial_id',request()->cookie('filial_id'))->where('created_at','>=',$Days)->get();
        $Qaytarildi = array();
        $QaytarildiSumma = 0;
        foreach ($JamiTulov as $key => $value) {
            if($value->type =='Qaytarildi (Naqt)' OR $value->type=='Qaytarildi (Plastik)'){
               $Qaytarildi[$key]['user_id'] = $value->user_id; 
               $Qaytarildi[$key]['user'] = User::find($value->user_id)->name; 
               $Qaytarildi[$key]['admin'] = User::find($value->admin_id)->email; 
               $Qaytarildi[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
               $Qaytarildi[$key]['type'] = $value->type; 
               $Qaytarildi[$key]['about'] = $value->about; 
               $Qaytarildi[$key]['created_at'] = $value->created_at; 
               $QaytarildiSumma = $QaytarildiSumma+$value->summa;
            }
        } 
        $QaytarildiSumma = number_format(($QaytarildiSumma), 0, '.', ' ');
        $TulovDelete = TulovDelete::where('filial_id',request()->cookie('filial_id'))->where('created_at','>=',$Days)->get();
        $TulDel = array();
        foreach ($TulovDelete as $key => $value) {
            $TulDel[$key]['student'] = User::find($value->user_id)->name;
            $TulDel[$key]['admin'] = User::find($value->admin_id)->email;
            $TulDel[$key]['user_id'] = $value->user_id;
            $TulDel[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $TulDel[$key]['type'] = $value->type;
            $TulDel[$key]['created_at'] = $value->created_at;
        }
        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',request()->cookie('filial_id'))->first();
        $IshHaq = array();
        $IshHaq['naqt'] = number_format(($MavjudIshHaqi->naqt), 0, '.', ' ');
        $IshHaq['plastik'] = number_format(($MavjudIshHaqi->plastik), 0, '.', ' ');
        return view("Admin.moliya.index",compact('TulDel','QaytarildiSumma','Qaytarildi','Kassa','Chiqim','Xarajat','IshHaq'));
    } 
    public function chiqim(Request $request){
        $naqt = str_replace(" ","",$request->naqt);
        $plastik = str_replace(" ","",$request->plastik);
        $summa = str_replace(",","",$request->summa);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($request->type=='Naqt'){
            if($summa>$naqt){return redirect()->back()->with('error', "Kassada mablag' yetarli emas."); }
            $FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt-$summa;
            $FilialKassa->tulov_naqt_chiqim = $FilialKassa->tulov_naqt_chiqim+$summa;
        }
        if($request->type=='Plastik'){
            if($summa>$plastik){return redirect()->back()->with('error', "Kassada mablag' yetarli emas."); }
            $FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik-$summa;
            $FilialKassa->tulov_plastik_chiqim = $FilialKassa->tulov_plastik_chiqim+$summa;
        }
        $FilialKassa->save();
        $Moliya = Moliya::create([
            'filial_id'=>request()->cookie('filial_id'),
            'xodisa'=>$request->xodisa,
            'summa'=>$summa,
            'type'=>$request->type,
            'status'=>'false',
            'about'=>$request->about,
            'user_id'=>Auth::User()->id,
        ]);
        return redirect()->back()->with('success', "Kassadan chiqim qilindi. Tasdiqlanish kutilmoqda");
    }
    public function chiqimdelete(Request $request){
        $Moliya = Moliya::find($request->id);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($Moliya->type=='Naqt'){
            $FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt+$Moliya->summa;
            $FilialKassa->tulov_naqt_chiqim = $FilialKassa->tulov_naqt_chiqim-$Moliya->summa;
        }
        if($Moliya->type=='Plastik'){
            $FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik+$Moliya->summa;
            $FilialKassa->tulov_plastik_chiqim = $FilialKassa->tulov_plastik_chiqim-$Moliya->summa;
        }
        $FilialKassa->save();
        $Moliya->delete();
        return redirect()->back()->with('success', "Tasdiqlanmagan chiqim bekor qilindi.");
    }
    public function chiqimtasdiq(Request $request){
        $Moliya = Moliya::find($request->id);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        $Filial = Filial::find(request()->cookie('filial_id'));
        if($Moliya->type=='Naqt'){
            $FilialKassa->tulov_naqt_chiqim = $FilialKassa->tulov_naqt_chiqim-$Moliya->summa;
            $FilialKassa->tulov_naqt_chiqim_tasdiqlandi = $FilialKassa->tulov_naqt_chiqim_tasdiqlandi+$Moliya->summa;
            $Filial->naqt = $Filial->naqt + $Moliya->summa;
        }
        if($Moliya->type=='Plastik'){
            $FilialKassa->tulov_plastik_chiqim = $FilialKassa->tulov_plastik_chiqim-$Moliya->summa;
            $FilialKassa->tulov_plastik_chiqim_tasdiqlandi = $FilialKassa->tulov_plastik_chiqim_tasdiqlandi+$Moliya->summa;
            $Filial->plastik = $Filial->plastik + $Moliya->summa;
        }
        $Filial->save();
        $FilialKassa->save();
        $Moliya->status = 'true';
        $Moliya->admin_id = Auth::User()->id;
        $Moliya->save();
        return redirect()->back()->with('success', "Tasdiqlanmagan chiqim tasdiqlandi.");
    }
    public function xarajat(Request $request){
        $naqt = str_replace(" ","",$request->naqt);
        $plastik = str_replace(" ","",$request->plastik);
        $summa = str_replace(",","",$request->summa);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($request->type=='Naqt'){
            if($summa>$naqt){return redirect()->back()->with('error', "Kassada mablag' yetarli emas."); }
            $FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt-$summa;
            $FilialKassa->tulov_naqt_xarajat = $FilialKassa->tulov_naqt_xarajat+$summa;
        }
        if($request->type=='Plastik'){
            if($summa>$plastik){return redirect()->back()->with('error', "Kassada mablag' yetarli emas."); }
            $FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik-$summa;
            $FilialKassa->tulov_plastik_xarajat = $FilialKassa->tulov_plastik_xarajat+$summa;
        }
        $FilialKassa->save();
        $Moliya = Moliya::create([
            'filial_id'=>request()->cookie('filial_id'),
            'xodisa'=>$request->xodisa,
            'summa'=>$summa,
            'type'=>$request->type,
            'status'=>'false',
            'about'=>$request->about,
            'user_id'=>Auth::User()->id,
        ]);
        return redirect()->back()->with('success', "Kassadan xarajatlar uchun chiqim qilindi. Tasdiqlanish kutilmoqda");
    }
    public function xarajatdelete(Request $request){
        $Moliya = Moliya::find($request->id);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($Moliya->type=='Naqt'){
            $FilialKassa->tulov_naqt = $FilialKassa->tulov_naqt+$Moliya->summa;
            $FilialKassa->tulov_naqt_xarajat = $FilialKassa->tulov_naqt_xarajat-$Moliya->summa;
        }
        if($Moliya->type=='Plastik'){
            $FilialKassa->tulov_plastik = $FilialKassa->tulov_plastik+$Moliya->summa;
            $FilialKassa->tulov_plastik_xarajat = $FilialKassa->tulov_plastik_xarajat-$Moliya->summa;
        }
        $FilialKassa->save();
        $Moliya->delete();
        return redirect()->back()->with('success', "Tasdiqlanmagan xarajat bekor qilindi.");
    }
    public function xarajattasdiq(Request $request){
        $Moliya = Moliya::find($request->id);
        $FilialKassa = FilialKassa::where('filial_id',request()->cookie('filial_id'))->first();
        if($Moliya->type=='Naqt'){
            $FilialKassa->tulov_naqt_xarajat = $FilialKassa->tulov_naqt_xarajat-$Moliya->summa;
            $FilialKassa->tulov_naqt_xarajat_tasdiqlandi = $FilialKassa->tulov_naqt_xarajat_tasdiqlandi+$Moliya->summa;
        }
        if($Moliya->type=='Plastik'){
            $FilialKassa->tulov_plastik_xarajat = $FilialKassa->tulov_plastik_xarajat-$Moliya->summa;
            $FilialKassa->tulov_plastik_xarajat_tasdiqlandi = $FilialKassa->tulov_plastik_xarajat_tasdiqlandi+$Moliya->summa;
        }
        $FilialKassa->save();
        $Moliya->status = 'true';
        $Moliya->admin_id = Auth::User()->id;
        $Moliya->save();
        return redirect()->back()->with('success', "Tasdiqlanmagan xarajat tasdiqlandi.");
    }
}
