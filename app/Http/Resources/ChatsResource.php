<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::find($this->admin_id);
        if($this->admin_id == null){
            return [
                'message' => $this->message,
                'user_id' => $this->user_id ,
                'admin_id' => $this->admin_id,
                'user_name' => $this->user->name,
                'role' => $this->user->role,
            ];
        }else{
            return [
                'message' => $this->message,
                'user_id' => $this->user_id ,
                'admin_id' => $this->admin_id,
                'user_name' => $user->name,
                'role' => $user->role,
            ];
        }
        
    }
}
