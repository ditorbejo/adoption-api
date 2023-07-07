<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';

    protected $fillable = ['name','gender','status_adopt','certificate','categories_id','image', 'color', 'weight' ,'description', 'date_birth'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id'); #categories_id adalah foreign key
    }
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }
    public function underReviewAdoptions()
    {
        return $this->hasMany(Adoption::class)->where('status' , 'review');
    }
    public function adopter(){
        return Adoption::where('pet_id', $this->id)->where('status','approve')->first();
    }
    // public function updatePetAdoptionForm()
    // {
    //     return $this->hasMany(Adoption::class)->where('status' , 'review');
    // }
}
