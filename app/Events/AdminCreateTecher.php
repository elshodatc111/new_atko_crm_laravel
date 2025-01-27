<?php

namespace App\Events;
use App\Models\User;
use App\Models\Filial;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminCreateTecher
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone;
    public $password;
    public $filial;
    public $name;
    public $login;
    public function __construct($user_id,$password){
        $this->password = $password;
        $this->phone = "+998".str_replace(" ","",User::find($user_id)->phone);
        $this->name = str_replace(" ","",User::find($user_id)->name);
        $this->login = str_replace(" ","",User::find($user_id)->email);
        $this->filial = Filial::where('id',User::find($user_id)->filial_id)->first()->filial_name;
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
