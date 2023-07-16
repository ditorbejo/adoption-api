<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Resources\AdoptionResource;
use App\Models\Adoption;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdoptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['auth:sanctum','abilities:admin'])->only(['update','destroy','adopt','markAsAdopt']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id= $request->query('user_id');
        $status = $request->query('status');
        
        if($user_id){
            $data = Adoption::where('user_id',$user_id)->get();
        }
        if($status){
            $data = Adoption::where('status',$status)->get();
        }
        $result = AdoptionResource::collection($data);
        return $this->sendResponse($result, 'Berhasil mendapatkan data adoptions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdoptionRequest $request)
    {
        $create = Adoption::create([
            'name_adopter' => $request->name_adopter,
            'phone_adopter' => $request->phone_adopter,
            'address_adopter' => $request->address_adopter,
            'status' => 'review',
            'email' => $request->email,
            'pet_id' => $request->pet_id,
            'user_id' => $request->user_id,
            'description' => $request->description,
        ]);
        $data = new AdoptionResource($create);
        return $this->sendResponse($data, 'Berhasil Menambahkan Form Adopt');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function show(Adoption $adoption)
    {
        $check = Adoption::find($adoption->id);
        if(!$check){
            abort(404,'Object not found');
        }
        $data = new AdoptionResource($check);
        return $this->sendResponse($data, 'Berhasil mendapatkan form data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adoption $adoption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adoption $adoption)
    {
        $result = $adoption->delete();
        return $this->sendResponse($result, 'Data form adopt berhasil dihapus');
    }
    public function adopt(Adoption $adoption)
    {
        if($adoption->status == 'review'){
        $pet = $adoption->pet;
        if($pet->status == 'adopted'){
            $result = [
                'message' => "Tidak bisa adopsi kucing sudah diadopsi",
            ];
            return response()->json($result, Response::HTTP_BAD_REQUEST);
        }
        $pet->update(['status_adopt' => 'adopted']);
        $adoption->update(['status' => 'approve']);
        $pet->underReviewAdoptions()->update(['status' => 'unavailable']);
        $result = new AdoptionResource($adoption);
        return $this->sendResponse($result, 'Kucing berhasil diadopsi');
        }

        $status = $adoption->status;
        $result = [
            'message' => "Tidak bisa adopsi. Status:$status",
        ];
        return response()->json($result, Response::HTTP_BAD_REQUEST);
        
        
    }
    public function markAsAdopt(StoreAdoptionRequest $request, Adoption $adoption)
    {

        $pet = Pet::find($request->pet_id);
        if($pet->status_adopt == 'adopted'){
            $result = [
                'message' => "Tidak bisa adopsi kucing sudah diadopsi",
            ];
            return response()->json($result, Response::HTTP_BAD_REQUEST);
        }else{
            $create = Adoption::create([
                'name_adopter' => $request->name_adopter,
                'phone_adopter' => $request->phone_adopter,
                'address_adopter' => $request->address_adopter,
                'status' => 'approve',
                'email' => $request->email,
                'pet_id' => $request->pet_id,
                'user_id' => $request->user_id,
                'description' => $request->description,
            ]);
            $pet->update(['status_adopt' => 'adopted']);
            $pet->underReviewAdoptions()->update(['status' => 'unavailable']);
            $result = new AdoptionResource($create);
            return $this->sendResponse($result, 'Kucing berhasil diadopsi');
        }

    }
    public function reject(Adoption $adoption)
    {
        if($adoption->status == 'review'){
        $pet = $adoption->pet;
        if($pet->status == 'adopted'){
            $result = [
                'message' => "Tidak bisa adopsi kucing sudah diadopsi",
            ];
            return response()->json($result, Response::HTTP_BAD_REQUEST);
        }
        $adoption->update(['status' => 'reject']);
        $result = new AdoptionResource($adoption);
        return $this->sendResponse($result, 'Form berhasil di reject');
        }
    }
}
