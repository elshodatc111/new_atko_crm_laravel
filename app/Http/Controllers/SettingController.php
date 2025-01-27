<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\SmsCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $Setting = Setting::find(1);
        $SmsCounter = SmsCounter::find(1);
        return view('setting', compact('Setting','SmsCounter'));
    }
    public function update(Request $request){
        $validated = $request->validate([
            'EndData' => 'required',
            'Summa' => 'required',
            'Username' => 'required',
        ]);
        if(isset($request->Status)){
            $validated['Status']='true';
        }else{
            $validated['Status']='false';
        }
        $Setting = Setting::find(1);
        $Setting->update($validated);
        return redirect()->back()->with('success', 'Markaz sozlamalari taxrirlandi.'); 
        dd($request);
    }
    public function smsplus(Request $request){
        $validated = $request->validate([
            'sms' => 'required'
        ]);
        $SmsCounter = SmsCounter::find(1);
        $SmsCounter->maxsms = $SmsCounter->maxsms+$request->sms;
        $SmsCounter->save();
        return redirect()->back()->with('success', 'SMS qo\'shildi.'); 
        dd($request);
    }
}
