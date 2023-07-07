<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
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
     */
    public function index()
    {
        $data = Announcement::all();
        $result = AnnouncementResource::collection($data);
        
        return $this->sendResponse($result, 'Berhasil mengambil data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $image = $request->file('image');
        $image = $request->image;
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/images');
            $create = Announcement::create([
                'title' => $request->title,
                'description' => $request->description,
                'image'=> $pathImage,
            ]);
        };
        $data = new AnnouncementResource($create);
        
        return $this->sendResponse($data, 'Data Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        $check = Announcement::find($announcement->id);
        if(!$check){ 
            abort(404, 'Object not found');
        }

        $data = new AnnouncementResource($check);

        return $this->sendResponse($data, 'Sukses mendapatkan pengumuman');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        if($request->hasFile('image')){
            $pathImage = $request->image->store('public/images');
            $oldDirectory = $announcement->image;
            Storage::delete($oldDirectory);
            $announcement->update([
                'image' => $pathImage
            ]);
        };
        $announcement->update([
            'title' => $request->title, 
            'description' => $request->description,
        ]);
        $result = new AnnouncementResource($announcement);

        return $this->sendResponse($result, 'Data Announcement berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $result = $announcement->delete();
        return $this->sendResponse($result, 'data berhasil dihapus');
    }
}
