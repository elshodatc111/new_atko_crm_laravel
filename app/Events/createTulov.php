<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class createTulov{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $naqt;
    public $plastik;
    public $guruh_id;
    public $about;
    public function __construct($user_id,$naqt,$plastik,$guruh_id,$about){
        $this->user_id = $user_id;
        $this->naqt = $naqt;
        $this->plastik = $plastik;
        $this->guruh_id = $guruh_id;
        $this->about = $about;
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
