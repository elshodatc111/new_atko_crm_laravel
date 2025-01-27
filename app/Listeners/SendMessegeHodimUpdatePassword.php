<?php
namespace App\Listeners;
use App\Models\SendMessege;
use App\Models\SmsCounter;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\HodimUpdatePasswor;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
class SendMessegeHodimUpdatePassword{
    public function __construct(){}
    public function handle(HodimUpdatePasswor $event): void{
        $Text = "Sizning yangi parolingiz Parol: ".$event->password." https://crm.atko.tech/";
        $eskiz_email = env('ESKIZ_UZ_EMAIL');
        $eskiz_password = env('ESKIZ_UZ_Password');
        $eskiz = new Eskiz($eskiz_email,$eskiz_password);
        $eskiz->requestAuthLogin();
        $from='4546';
        $mobile_phone = $event->phone;
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
            'phone'=> $event->phone,
            'text'=> strval($Text),
            'status'=>"Yuborildi"
        ]);
    }
}
