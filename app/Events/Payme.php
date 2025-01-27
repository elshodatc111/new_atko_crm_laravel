<?php

namespace App\Events;

use App\Models\User;
use App\Models\Guruh;
use App\Models\GuruhUser;
use App\Models\UserHistory;
use App\Models\Tulov;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Payme
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $summa;
    public $filial_id;
    public function __construct($user_id, $summa,$filial_id){
        $this->user_id = $user_id;
        $this->summa = $summa;
        $this->filial_id = $filial_id;
    }
    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
