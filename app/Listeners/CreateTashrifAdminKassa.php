<?php

namespace App\Listeners;
use App\Models\User;
use App\Models\AdminKassa;
use App\Events\CreateTashrif;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
class CreateTashrifAdminKassa{
    public function __construct(){}
    public function handle(CreateTashrif $event): void{
        if(Auth::user()->type!='SuperAdmin'){
            $AdminKassa = AdminKassa::where('user_id',Auth::user()->id)->first();
            $count = $AdminKassa->tashriflar;
            $AdminKassa->tashriflar = $count+1;
            $AdminKassa->save();
        }
    }
}
