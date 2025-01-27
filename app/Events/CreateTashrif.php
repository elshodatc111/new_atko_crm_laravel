<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTashrif{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $password;
    public $phone;
    public function __construct($user_id,$phone,$password){
        $this->user_id = $user_id;
        $this->phone = $phone;
        $this->password = $password;
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
