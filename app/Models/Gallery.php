<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = ['image','pet_id'];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
}
