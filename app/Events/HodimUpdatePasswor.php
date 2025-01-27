<?php

namespace App\Events;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
 
class HodimUpdatePasswor{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $phone;
    public $password;
    public function __construct($user_id,$password){
        $User = User::find($user_id);
        $this->phone = "+998".str_replace(" ","",$User->phone);
        $this->password = $password;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
