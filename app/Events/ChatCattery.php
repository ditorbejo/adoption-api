<?php

namespace App\Events;

use App\Http\Resources\ChatsResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatCattery implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $resourceData;

    public function __construct(ChatsResource $resource)
  {
        $this->resourceData = $resource;
  }
 
    public function broadcastOn()
  {
     $userId = $this->resourceData->user_id;
     return ["lorem-ipsum-chat-"."$userId"];

  }

  public function broadcastAs()
  {
      return 'chat-Cattery';
  }
    
}