<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $table = 'adoptions';
    protected $fillable = ['name_adopter','phone_adopter','status','address_adopter','email','pet_id','user_id','description','reject'];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
}
