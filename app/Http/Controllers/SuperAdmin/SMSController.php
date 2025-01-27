<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\SendMessege;
use App\Models\SmsCounter;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
class SMSController extends Controller{
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        $SmsCounter = SmsCounter::first();
        $SendMessege = SendMessege::where('created_at','>=',date("Y-m-d")." 00:00:00")->orderby('id','desc')->get();
        return view('SuperAdmin.sms.index',compact('SmsCounter','SendMessege'));
    }
    public function show(Request $request){
        $start = $request->start." 00:00:00";
        $end = $request->end." 23:59:59";
        $SendMessege = SendMessege::where('created_at','>=',$start)->where('created_at','<=',$end)->orderby('id','desc')->get();
        return view('SuperAdmin.sms.show',compact('SendMessege','start','end'));
    }
    public function send(Request $request){
        $Users = User::where('type','User')->get();
        $i=0;
        foreach ($Users as $key => $value) {
            $i++;
            $Phone = "+998".str_replace(" ","",$value->phone);
            $Text = $request->text;
            $eskiz_email = env('ESKIZ_UZ_EMAIL');
            $eskiz_password = env('ESKIZ_UZ_Password');
            $eskiz = new Eskiz($eskiz_email,$eskiz_password);
            $eskiz->requestAuthLogin();
            $from='4546';
            $mobile_phone = $Phone;
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
            $SmsCounter = SmsCounter::find(1);
            $SmsCounter->maxsms = $SmsCounter->maxsms - 1;
            $SmsCounter->counte = $SmsCounter->counte + 1;
            $SmsCounter->save();
            SendMessege::create([
                'text'=>$request->text,
                'phone'=>"+998".str_replace(" ","",$value->phone),
                'status'=>"Yuborildi"
            ]);
        }
        return redirect()->back()->with('success', $i.' ta talabaga sms yuborildi.'); 
    }
}
