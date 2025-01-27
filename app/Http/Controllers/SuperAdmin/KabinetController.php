<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KabinetController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function kabinet(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        return view('SuperAdmin.kabinet');
    }

    public function kabinetUpdate(Request $request, $id){
        $User  = User::find($id);
        $User->name = $request->name;
        $User->addres = $request->addres;
        $User->save();
        return redirect()->back()->with('success', 'Malumotlar yangilandi.'); 
    }

    public function kabinetPassword(Request $request, $id){
        $validated = $request->validate([
            'pass0' => 'required', 'min:8',
            'pass1' => 'required', 'min:8',
            'pass2' => 'required', 'min:8',
        ]);
        if($request->pass1 == $request->pass2){
            $User  = User::find($id);
            $User->password = Hash::make($request->pass2);
            $User->save();
            return redirect()->back()->with('success', 'Parol yangilandi.'); 
        }else{
            return redirect()->back()->with('error', 'Parol mos kelmadi.'); 
        }
    }
}
