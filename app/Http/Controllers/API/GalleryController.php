<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['auth:sanctum','ability:admin'])->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function index(Request $request)
    {
        $pet_id= $request->query('pet_id');
        
        if($pet_id){
            $data = Gallery::where('pet_id',$pet_id)->get();
        }
        $result = GalleryResource::collection($data);
        
        return $this->sendResponse($result, 'Berhasil mendapatkan semua data gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $image = $request->file('image');
        $image = $request->image;
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/images');
            $create = Gallery::create([
                'pet_id' => $request->pet_id,
                'image'=> $pathImage,
            ]);
            
        };
        $data = new GalleryResource($create);
        
        return $this->sendResponse($data, 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $check = Gallery::find($gallery->id);
        if(!$check){
            abort(404, 'Object not found');
        }
        $data = new GalleryResource($check);

        return $this->sendResponse($data, 'Mendapatkan image gallery');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/storage/galleries');
            $oldDirectory = $gallery->image;
            Storage::delete($oldDirectory);
            $gallery->update([
                'image' => $pathImage,
            ]);
        }
        $result = new GalleryResource($gallery);

        return $this->sendResponse($result, 'Image telah diupdate');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $result = $gallery->delete();
        return $this->sendResponse($result, ' Image berhasil dihapus ');
    }
}
