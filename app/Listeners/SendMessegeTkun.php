<?php

namespace App\Listeners;
use App\Events\TugilganKun;
use App\Models\SmsCentar;
use App\Models\SmsCounter;
use App\Models\SendMessege;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
use Illuminate\Support\Facades\Log;

class SendMessegeTkun{
    public function __construct(){}

    public function handle(TugilganKun $event){
        if($event->type=='on'){
			$Text = "Hurmatli ".$event->name." Sizni tug'ilgan kuningiz bilan tabriklaymiz. Hurmat bilan ATKO koreys tili markazi jamoasi.";
            //$Text = "Hurmatli ".$event->name." Sizni tug'ilgan kuningiz bilan chin yurakdan tabriklaymiz! Ushbu quvonchli kunda va yilning har bir kunida sizga omad va sog'lik, istaklaringizni amalga oshirish va ko'plab ijobiy his-tuyg'ularni tilaymiz. Hurmat bilan ".env('CRM_NAME')." o'quv markazi jamoasi.";
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
}
