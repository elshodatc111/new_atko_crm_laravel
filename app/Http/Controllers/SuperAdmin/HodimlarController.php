<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class HodimlarController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function hodimlar(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Users = User::where('type','SuperAdmin')->where('status','true')->where('id','!=',Auth::user()->id)->get();
        return view('SuperAdmin.hodimlar',compact('Users'));
    }

    public function hodimCreate(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users']
        ]);
        $parol = 12345678;
        $validate['filial_id'] = '2';
        $validate['phone2'] = $request->phone;
        $validate['type'] = 'SuperAdmin';
        $validate['status'] = 'true';
        $validate['smm'] = 'null';
        $validate['balans'] = 0;
        $validate['admin_id'] = Auth::user()->id;
        $validate['password'] = Hash::make($parol);
        User::create($validate);
        return redirect()->back()->with('success', 'Yangi admin yaratildi. Parol: 12345678'); 
    }

    public function HodimDeletes($id){
        $parol = 12345678;
        $User = User::find($id);
        $User->password = Hash::make($parol);
        $User->save();
        return redirect()->back()->with('success', 'Parol yangilandi.. Parol: 12345678');
    }
    
    public function HodimPassword($id){
        $User = User::find($id);
        $User->type = 'Deleted';
        $User->status = 'false';
        $User->save();
        return redirect()->back()->with('success', "Administrator o'chirildi."); 
    }
}
