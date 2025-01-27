<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class debitSendMessege{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $Filial;
    public $Messege;
    public function __construct($Messege,$Filial){
        $this->Filial = $Filial;
        $this->Messege = $Messege;
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
