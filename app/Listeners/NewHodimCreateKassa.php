<?php

namespace App\Listeners;
use App\Models\User;
use App\Models\Filial;
use App\Events\CreateHodim;
use App\Models\AdminKassa;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewHodimCreateKassa{
    public function __construct(){}
    public function handle(CreateHodim $event): void{
        $User = User::find($event->user_id);
        $AdminKassa = AdminKassa::create([
            'filial_id'=>$User->filial_id,
            'user_id'=>$event->user_id,
        ]);
    }
}
