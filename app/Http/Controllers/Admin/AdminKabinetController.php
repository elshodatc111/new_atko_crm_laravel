<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminKabinetController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function kabinet(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User'){
            auth()->logout();
            return redirect()->route('login');
        }
        return view('Admin.profel');
    }
    public function update(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255']
        ]);
        $User = User::find(Auth::User()->id);
        $User->update($validate);
        return redirect()->back()->with('success', "Malumotlar yangilandi.");
    }
    public function passwupdate(Request $request){
        $validate = $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'newpassword' => ['required', 'string', 'min:8'],
            'nextpassword' => ['required', 'string', 'min:8']
        ]);
        if($request->newpassword != $request->nextpassword){
            return redirect()->back()->with('error', "Parol mos emas.");
        }
        $User = User::find(Auth::User()->id);
        $User->update([
            'password'=>Hash::make($request->newpassword)
        ]);
        return redirect()->back()->with('success', "Parol yangilandi.");
    }
}
