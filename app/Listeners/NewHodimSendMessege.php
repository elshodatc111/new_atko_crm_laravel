<?php
namespace App\Listeners;
use App\Models\User;
use App\Models\SendMessege;
use App\Models\SmsCounter;
use App\Models\Filial;
use App\Events\CreateHodim;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class NewHodimSendMessege{
    public function __construct(){}
    public function handle(CreateHodim $event): void{
        $User = User::find($event->user_id);
        $Filial_Name = Filial::where('id',$User->filial_id)->first()->filial_name;
        $Phone = "+998".str_replace(" ","",$User->phone);
        $Text = $User->name." Siz ".env('CRM_NAME')." o'quv markazimizga ishga olindingiz. Login: ".$User->email." Parol: 12345678 websayt: ".env('CRM_LINK');
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
            'phone'=> $Phone,
            'text'=> strval($Text),
            'status'=>"Yuborildi"
        ]);
    }
}
