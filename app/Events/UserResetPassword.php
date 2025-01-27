<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserResetPassword{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $fio;
    public $password;
    public $phone;
    public function __construct($fio,$password,$phone){
        $this->fio = $fio;
        $this->password = $password;
        $this->phone = "+998".str_replace(" ","",$phone);
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
