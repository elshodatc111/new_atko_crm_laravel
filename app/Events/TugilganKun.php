<?php

namespace App\Events;
use App\Models\User;
use App\Models\Filial;
use App\Models\SmsCentar;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TugilganKun{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $name;
    public $phone;
    public $filial;
    public $type;
    public function __construct($id){
        $this->name = User::find($id)->name;
        $this->phone = "+998".str_replace(" ","", User::find($id)->phone );
        $this->filial = Filial::find(User::find($id)->filial_id)->filial_name;
        $this->type = SmsCentar::where('filial_id',User::find($id)->filial_id)->first()->tkun;
    }

    public function broadcastOn(): array{
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
