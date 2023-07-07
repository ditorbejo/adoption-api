<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['auth:sanctum','abilities:admin'])->only(['store','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all(); #semuadata
        $result = CategoryResource::collection($data); #sortir data
        return $this->sendResponse($result, 'Successfull Get Category');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = new CategoryResource(Category::create($request->validated())); #Category resource (sortir) baru yang berasal dari kategori yang dibuat
        return $this->sendResponse($data, 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $check = Category::find($category->id); #mencari kategori berdasarkan id
        if(!$check){ 
            abort(404, 'Object not found'); #jika kategori id tidak ditemukan maka memunculkan 404 dan pesan object not found
        }

        $data = new CategoryResource($check); #kategori resource dari hasil kategori berdasarkan id

        return $this->sendResponse($data, 'Sukses mendapatkan kategori');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        $result = new CategoryResource($category);

        return $this->sendResponse($result, 'Data kategori berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

        return $this->sendResponse($result, 'Data kategori berhasil dihapus');
    }
}
