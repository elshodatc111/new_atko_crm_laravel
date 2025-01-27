<?php

namespace App\Http\Controllers\Admin;
use App\Models\Room;
use App\Models\User;
use App\Models\GuruhUser;
use App\Models\Murojat;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Guruh;
use App\Models\Eslatma;
use App\Models\GuruhTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller{
    public function __construct(){$this->middleware('auth');}
    public function coocies(){
        if(Auth::user()->filial_id != request()->cookie('filial_id')){
            if(Auth::user()->type != 'SuperAdmin'){
                Auth::logout();
                return view('home')->withCookie('filial_id', ' ', -86400)->withCookie('filial_name', ' ', -86400);
            }
        }
        if(!request()->cookie('filial_name')){
            return view('home')->withCookie('filial_id', ' ', -86400)->withCookie('filial_name', ' ', -86400);
        }
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        $this->coocies();
        $SettingEndData = date("Y-m-d", strtotime('-3 day',strtotime(Setting::find(1)->EndData)));
        $times = date("Y-m-d");
        if($times>$SettingEndData){$Block = 'true';
        }else{$Block = "false";}

        $weekStart = strtotime('monday this week', time());
        $Room = Room::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        $room_id = 1;
        $Rooms = array();
        foreach($Room as $key => $value ){
            $Rooms[$key]['guruh_id'] = $value->id;
            $Rooms[$key]['room_name'] = $value->room_name;
            $Jadval = array();
            for ($k = 1; $k <= 9; $k++) {
                for ($i = 0; $i < 6; $i++) {
                    $day = date('Y-m-d', strtotime("+$i days", $weekStart));
                    
                    $GuruhJadval = GuruhTime::where('room_id',$value->id)
                                ->where('times',$k)->where('dates',$day)->get();
                    if(count($GuruhJadval)>0){
                        $guruh_id = $GuruhJadval->first()->guruh_id;
                        $guruh_name = Guruh::where('id',$guruh_id)->get()->first()->guruh_name;
                        $Jadval[$i][$k]['guruh_id'] = $guruh_id;
                        $Jadval[$i][$k]['guruh_name'] = $guruh_name;
                    }else{$Jadval[$i][$k] = 'bosh';}
                }
            }
            $Rooms[$key]['hafta_kun'] = $Jadval;
        }

        $Users = User::where('filial_id',request()->cookie('filial_id'))->where('type','User')->orderby('id','desc')->get();
        $User = array();
        foreach ($Users as $key => $value) {
            $User[$key]['id']=$value->id;
            $User[$key]['name']=$value->name;
            $User[$key]['addres']=$value->addres;
            $User[$key]['phone']=$value->phone;
            $GuruhUser = count(GuruhUser::where('user_id',$value->id)->where('status','true')->get());
            $User[$key]['created_at']=$GuruhUser;
            $User[$key]['guruhlar']=$value->created_at;
        }
        return view('Admin.index', compact('Rooms','User','Block'));
    }
    public function eslatmalar(){
        $Eslatma = array();
        $ess = Eslatma::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        if($ess){
            foreach($ess as $key => $item){
                $Eslatma[$key]['id'] = $item->id;
                $Eslatma[$key]['type'] = $item->type;
                if($item->type=='user'){
                    $Eslatma[$key]['name'] =User::where('id',$item->user_guruh_id)->first()->name;
                }else{
                    $Eslatma[$key]['name'] = Guruh::find($item->user_guruh_id)->guruh_name;
                }
                $Eslatma[$key]['user_guruh_id'] = $item->user_guruh_id;
                $Eslatma[$key]['text'] = $item->text;
                $Eslatma[$key]['created_at'] = $item->created_at;
                $Eslatma[$key]['meneger'] = User::find($item->admin_id)->email;
            }
        }
        $Eslatma_arxiv = array();
        $arxiv = Eslatma::where('filial_id',request()->cookie('filial_id'))->where('status','false')->orderby('id','desc')->get();
        if($arxiv){
            foreach($arxiv as $key=>$item){
                $Eslatma_arxiv[$key]['id'] = $item->id;
                $Eslatma_arxiv[$key]['type'] = $item->type;
                if($item->type=='user'){
                    $Eslatma_arxiv[$key]['name'] =User::where('id',$item->user_guruh_id)->first()->name;
                }else{
                    $Eslatma_arxiv[$key]['name'] = Guruh::find($item->user_guruh_id)->guruh_name;
                }
                $Eslatma_arxiv[$key]['user_guruh_id'] = $item->user_guruh_id;
                $Eslatma_arxiv[$key]['text'] = $item->text;
                $Eslatma_arxiv[$key]['created_at'] = $item->created_at;
                $Eslatma_arxiv[$key]['meneger'] = User::find($item->admin_id)->email;
            }
        }
        return view('Admin.messege.eslatma',compact('Eslatma','Eslatma_arxiv'));
    }
    public function eslatmaarxiv($id){
        $Eslatma = Eslatma::find($id);
        $Eslatma->status='false';
        $Eslatma->save();
        return redirect()->back()->with('success', "Eslatma arxivlansi.");
    }
    public function murojatlar(){
        $Users = User::where('filial_id',request()->cookie('filial_id'))->get();
        $Murojatlar = array();

        foreach ($Users as $key => $value) {
            $Murojat = Murojat::where('user_id',$value->id)->orderBy('created_at', 'desc')->first();
            if($Murojat){
                $Murojatlar[$key]['user_id'] = $value->id;
                $Murojatlar[$key]['name'] = $value->name;
                $Murojatlar[$key]['text'] = $Murojat->text;
                $Murojatlar[$key]['admin_type'] = $Murojat->admin_type;
                $Murojatlar[$key]['created_at'] = $Murojat->created_at;
            }
        }
        return view('Admin.messege.murojat',compact('Murojatlar'));
    }
    public function murojatlarShow($id){
        $Users = User::where('filial_id',request()->cookie('filial_id'))->get();
        $Murojatlar = array();
        foreach ($Users as $key => $value) {
            $Murojat = Murojat::where('user_id',$value->id)->orderBy('created_at', 'desc')->first();
            if($Murojat){
                $Murojatlar[$key]['user_id'] = $value->id;
                $Murojatlar[$key]['name'] = $value->name;
                $Murojatlar[$key]['text'] = $Murojat->text;
                $Murojatlar[$key]['admin_type'] = $Murojat->admin_type;
                $Murojatlar[$key]['created_at'] = $Murojat->created_at;
            }
        }
        $Murojat2 = Murojat::where('user_id',$id)->get();
        $chat = array();
        foreach ($Murojat2 as $key => $value) {
            if($value->status=='admin'){
                $chat[$key]['admin'] = User::find($value->admin_id )->name;
            }else{
                $chat[$key]['admin'] = User::find($value->user_id )->name;
                $value->admin_type = 'false';
                $value->save();
            }
            $chat[$key]['status'] = $value->status;
            $chat[$key]['text'] = $value->text;
            $chat[$key]['created_at'] = $value->created_at;
        }
        return view('Admin.messege.murojat_show',compact('Murojatlar','id','chat'));
    }
    public function murojatlarCreate(Request $request){
        $validate = $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:255'],
        ]);
        $validate['filial_id'] = request()->cookie('filial_id');
        $validate['user_type'] = 'true';
        $validate['admin_id'] = Auth::user()->id;
        $validate['admin_type'] = 'true';
        $validate['status'] = 'admin';
        Murojat::create($validate);
        return redirect()->back()->with('success', "Murohatga javob yuborildi.");
    }

    public function tkun(){
        $today = Carbon::today();
        $tkun = User::where('filial_id',request()->cookie('filial_id'))->where('type','User')->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->get();
        return view('Admin.messege.tkun', compact('tkun'));
    }
    public function elonlar(){
        return view('Admin.messege.elon');
    }
    
    public function sendMessege(){
        $Eslatma = Eslatma::find(4);
        $Eslatma->status='true';
        $Eslatma->save();
    }

}
