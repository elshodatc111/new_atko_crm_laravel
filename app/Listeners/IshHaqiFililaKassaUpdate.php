<?php

namespace App\Listeners;

use App\Models\FilialKassa;
use App\Models\MavjudIshHaqi;
use App\Events\CreatIshHaqi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
class IshHaqiFililaKassaUpdate{
    public function __construct(){}
    public function handle(CreatIshHaqi $event): void{
        $type = $event->type;
        $summa = intval($event->summa);
        $filial_id = $event->filial_id;
        $MavjudIshHaqi = MavjudIshHaqi::where('filial_id',$filial_id)->first();
        $FilialKassa = FilialKassa::where('filial_id',$filial_id)->first();
        if($type=='Naqt'){
            $FilialKassa->tulov_naqt_ish_haqi = intval($FilialKassa->tulov_naqt_ish_haqi)+$summa;
            $MavjudIshHaqi->naqt = intval($MavjudIshHaqi->naqt)-$summa;
        }else{
            $FilialKassa->tulov_plastik_ish_haqi = intval($FilialKassa->tulov_plastik_ish_haqi)+$summa;
            $MavjudIshHaqi->plastik = intval($MavjudIshHaqi->plastik)-$summa;
        }
        $MavjudIshHaqi->save();
        $FilialKassa->save();
    }
}
