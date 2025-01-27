<?php
namespace App\Listeners;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use mrmuminov\eskizuz\Eskiz;
use App\Models\SmsCounter;
use App\Models\SendMessege;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
use App\Events\AdminCreateTecher;
class SendMessegeCreatTecher{
    public function __construct(){}
    public function handle(AdminCreateTecher $event): void{
        $text = $event->name." ".env('CRM_NAME')." o'quv markazida o'qituvchi lavozimida ishga olindingiz.\nLogin: ".$event->login."\nParol: ".$event->password."\nWebSayt: ".env('CRM_LINK');
        $eskiz_email = env('ESKIZ_UZ_EMAIL');
        $eskiz_password = env('ESKIZ_UZ_Password');
        $eskiz = new Eskiz($eskiz_email,$eskiz_password);
        $eskiz->requestAuthLogin();
        $from='4546';
        $mobile_phone = $event->phone;
        $message = $text;
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
            'phone'=> $event->phone,
            'text'=> strval($text),
            'status'=>"Yuborildi"
        ]);
    }
}
