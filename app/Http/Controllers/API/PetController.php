<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetsRequest;
use App\Http\Requests\UpdatePetsRequest;
use App\Http\Resources\PetsResource;
use App\Models\Pet;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stringable;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['auth:sanctum','abilities:admin'])->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('name');
        $certificate = $request->query('certificate');
        $color = $request->query('color');
        $status_adopt = $request->query('status_adopt');
        $message = "Data berhasil didapatkan";
        $pet_id= $request->query('pet_id');
        $categories_id = $request->query('categories_id');
        
        $data = Pet::all();
        if($categories_id){
            $data = Pet::where('categories_id',$categories_id)->get();
        }
        if($name){
            $data = Pet::where('name',$name)->get();
        }
        if ($status_adopt){
            $data = Pet::where('status_adopt',$status_adopt)->get();
        }
        if ($color && $status_adopt){
            $data = Pet::where('color', 'LIKE', '%' .$color. '%')->where('status_adopt',$status_adopt)->get();
        }if($categories_id && $status_adopt){
            $data = Pet::where('categories_id',$categories_id)->where('status_adopt',$status_adopt)->get();
        }
        $result = PetsResource::collection($data);

        return $this->sendResponse($result, $message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetsRequest $request)
    {
        $image = $request->file('image');
        $image = $request->image;
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/images'); #disimpan di direktori
            $create = Pet::create([ 
                'name' => $request->name, 
                'gender'=> $request->gender, 
                'status_adopt' => $request->status_adopt,
                'certificate'=> $request->certificate,
                'color'=> $request->color, 
                'categories_id' => $request->categories_id, 
                'date_birth' => $request->date_birth,
                'weight' => $request->weight,
                'description' => $request->description,
                'image'=> $pathImage, 
            ]);
            
        };
        $data = new PetsResource($create);
        
        return $this->sendResponse($data, 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        $check = Pet::find($pet->id); #mencari kategori berdasarkan id
        if(!$check){ 
            abort(404, 'Object not found'); #jika kategori id tidak ditemukan maka memunculkan 404 dan pesan object not found
        }

        $data = new PetsResource($check); #kategori resource dari hasil kategori berdasarkan id

        return $this->sendResponse($data, 'Sukses mendapatkan data hewan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePetsRequest $request, Pet $pet)
    {
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/images');
            $oldDirectory = $pet->image;
            Storage::delete($oldDirectory);
            $pet->update([
                'image' => $pathImage
            ]);
        };
        $pet->update([
            'name' => $request->name, 
            'gender'=> $request->gender, 
            'certificate'=> $request->certificate, 
            'color'=> $request->color,
            'categories_id' => $request->categories_id, 
            'date_birth' => $request->date_birth,
            'weight' => $request->weight,
            'description' => $request->description,
        ]);
        $result = new PetsResource($pet);

        return $this->sendResponse($result, 'Data pets berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $result = Gallery::where('pet_id',$pet->id)->delete();
        $pet->delete();
        return $this->sendResponse($result, 'data berhasil dihapus');
    }
}
