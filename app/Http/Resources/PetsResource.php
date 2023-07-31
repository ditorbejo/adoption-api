<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PetsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dateBirth = $this->date_birth;
        $dateTime = new DateTime($dateBirth);
        $formattedDate = $dateTime->format("d F Y");
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'status_adopt' =>$this->status_adopt,
            'certificate' => $this->certificate,
            'color' => $this->color,
            'date_birth' => $dateBirth,
            'format_date_birth' => $formattedDate,
            'weight' => $this->weight,
            'description' => $this->description,
            'categories_id' => $this->category->id,
            'categories_name' =>$this->category->namecategory,
            'image' => Storage::url($this->image),
            'adopter' => $this->adopter(),
        ];
    }
}
