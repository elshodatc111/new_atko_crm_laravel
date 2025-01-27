<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Payme;
use App\Models\SmsCounter;
use App\Models\User;
use App\Models\SmsCentar;
use App\Models\Guruh;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\UserHistory;
use App\Models\Tulov;
use App\Models\ChegirmaDay;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
class PaymeChegirma{
    public function __construct(){
        //
    }

    public function handle(Payme $event): void{
        $user_id = $event->user_id;
        $summa = $event->summa;
        $guruh_id = "NULL";
        $chegirma = 0;
        $guruh_Name = "NULL";
        $GuruhUser = GuruhUser::where('user_id',$user_id)->where('status','true')->get();
        $ChegirmaDay = ChegirmaDay::where('filial_id',$event->filial_id)->first()->days;
        $ChegirmaDays = date("Y-m-d",strtotime('-'.$ChegirmaDay.' day',strtotime(date('Y-m-d'))));
        if($GuruhUser){
            foreach ($GuruhUser as $key => $value) {
                $Guruh = Guruh::where('id',$value->guruh_id)
                    ->where('guruh_start','>=',$ChegirmaDays)->first();
                $Tulov = count(Tulov::where('user_id',$user_id)
                    ->where('guruh_id',$value->guruh_id)
                    ->where('type','Chegirma')->get());
                if($Tulov==0){
                    $tulov = $Guruh->guruh_price-$Guruh->guruh_chegirma;
                    if($summa==$tulov){
                        $guruh_id = $value->guruh_id;
                        $guruh_Name = $value->guruh_name;
                        $chegirma = $Guruh->guruh_chegirma;
                    }
                }
            }
        }

        $Users = User::where('id',$user_id)->first();
        $Balans1=$Users->balans;
        $Hisob1 = $Balans1."+".$summa."=".$Users->balans+$summa;
        $Balans2=$Users->balans+$summa;
        $Hisob2 = $Balans2."+".$chegirma."=".$Balans2+$chegirma;
        $Users->balans = $Users->balans+$summa+$chegirma;
        $Users -> save();
        $filial_id = $Users->filial_id;
        $Filial = Filial::find($filial_id);
        $Filial->payme = $Filial->payme+$summa;
        $Filial->save();
        $Tulov = Tulov::create([
            'filial_id'=>$Users->filial_id,
            'user_id'=>$user_id,
            'guruh_id'=>$guruh_id,
            'summa'=>$summa,
            'type'=>"Payme",
            'status'=>'true',
            'about'=>"Payme",
            'admin_id'=>1,
        ]);
        if($chegirma!=0){
            $Tulov2 = Tulov::create([
                'filial_id'=>$Users->filial_id,
                'user_id'=>$user_id,
                'guruh_id'=>$guruh_id,
                'summa'=>$chegirma,
                'type'=>"Chegirma",
                'status'=>'true',
                'about'=>"Payme",
                'admin_id'=>1,
            ]);
        }
        $UserHistory = UserHistory::create([
            'filial_id'=>$Users->filial_id,
            'user_id'=>$user_id,
            'status'=>"Payme",
            'type'=>$guruh_Name,
            'summa'=>$summa,
            'xisoblash'=>$Hisob1,
            'balans'=>$Balans2,
        ]);
        if($chegirma!=0){
            $UserHistory2 = UserHistory::create([
                'filial_id'=>$Users->filial_id,
                'user_id'=>$user_id,
                'status'=>"Chegirma",
                'type'=>$guruh_Name,
                'summa'=>$chegirma,
                'xisoblash'=>$Hisob2,
                'balans'=>$Balans2+$chegirma,
            ]);
        }

        $Phone = "+998".str_replace(" ","",$Users->phone);
        $Name = $Users->name;
        $Filial = Filial::where('id',$Users->filial_id)->first()->filial_name;
        if($chegirma!=0){
            $Text = "Hurmatli ".$Name." ".env('CRM_NAME')." o'quv markazi kurslar uchun ".$summa." so'm to'lov qabul qilindi va siz ".$chegirma." so'mlik chegirma oldingiz.";    
        }else{
            $Text = "Hurmatli ".$Name." ".env('CRM_NAME')." o'quv markazi kurslar uchun ".$summa." so'm to'lov qabul qilindi.";    
        }
        $SmsCentar = SmsCentar::where('filial_id',$Users->filial_id)->first()->tulov;
        if($SmsCentar=='on'){
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
        }
        
    }
}
