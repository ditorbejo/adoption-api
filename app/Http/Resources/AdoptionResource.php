<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdoptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
        'id'=>$this->id,
        'name_adopter' => $this->name_adopter,
        'phone_adopter' => $this->phone_adopter,
        'address_adopter' => $this->address_adopter,
        'status' => $this->status,
        'email' => $this->email,
        'user_id' => $this->user_id,
        'pet_id' => $this->pet->id,
        'pet_name' => $this->pet->name,
        'pet_image' => Storage::url($this->pet->image),
        'status_adopt' => $this->pet->status_adopt,
        'description' => $this->description,
        'reject' => $this->reject,
        'updated_at' => $this->updated_at->format('F d, Y'),
        ];
        
    }
}
