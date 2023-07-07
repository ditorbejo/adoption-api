<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Adoption;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Pet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Category::create([
            'namecategory' => 'British Short Hair'
        ]);
        Category::create([
            'namecategory' => 'American Short Hair'
        ]);
        Category::create([
            'namecategory' => 'Oriental Short Hair'
        ]);

        Pet::create([
            'name'=>'Boni',
            'gender'=> 'male',
            'status_adopt'=>'ready',
            'certificate'=> 'ICC-WCF',
            'color'=>'Black',
            'categories_id'=>'1',
            'image'=>'public/storage/image/gambar1.png',
            'date_birth'=>'2000-07-08',
            'weight'=>'3',
            'description' => 'Cakep Bulat dan Bulu halus dan sudah vaksin'
        ]);
        Pet::create([
            'name'=>'Coji',
            'gender'=> 'female',
            'status_adopt'=>'ready',
            'certificate'=> 'ICC-WCF',
            'color'=>'Black',
            'categories_id'=>'1',
            'image'=>'public/storage/image/gambar2.png',
            'date_birth'=>'2000-07-08',
            'weight'=>'5',
            'description' => 'Bulu halus dan sudah vaksin'
        ]);
        Pet::create([
            'name'=>'Tokio',
            'gender'=> 'male',
            'status_adopt'=>'ready',
            'certificate'=> 'ICC-WCF',
            'color'=>'Golden',
            'categories_id'=>'1',
            'image'=>'public/storage/image/gambar3.png',
            'date_birth'=>'2000-07-08',
            'weight'=>'4',
            'description' => 'Cakep Bulat dan sudah vaksin'
        ]);
        Pet::create([
            'name'=>'Kino',
            'gender'=> 'female',
            'status_adopt'=>'ready',
            'certificate'=> 'ICC-WCF',
            'color'=>'Blue',
            'categories_id'=>'1',
            'image'=>'public/storage/image/gambar4.png',
            'date_birth'=>'2000-07-08',
            'weight'=>'5',
            'description' => 'Cakep Bulat dan Bulu halus dan sudah vaksin'
        ]);


    }
}
