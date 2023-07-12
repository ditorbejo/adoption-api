<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Events\ChatCattery;
use App\Events\NewUserChats;
use App\Http\Resources\ChatsResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['auth:sanctum','abilities:admin'])->only(['sendMessageAdmin','fetchMessagesAdmin']);

    }

    public function index(Request $request)
    {
        $data = Message::all();
        $result = ChatsResource::collection($data);
        return $this->sendResponse($result, 'Berhasil mendapatkan data');
    }

    public function fetchMessages(Request $request)
    {
        $data = Message::where('user_id', $request->user()->id)->get();
        return ChatsResource::collection($data);
    }

    public function fetchMessagesAdmin(String $userId)
    {
        $data = Message::where('user_id',$userId)->get();
        return ChatsResource::collection($data);
    }

    public function sendMessageAdmin(Request $request , $userId)
    {
        $create = Message::create([
            'message' => $request->input('message'),
            'user_id' => (int)$userId,
            'admin_id' => request()->user()->id,
        ]);
        $result = new ChatsResource($create);
        event(new ChatCattery($result));
        return $this->sendResponse($result, 'Pesan Terkirim');
    }

    public function sendMessageUser(Request $request)
    {
        $checkMessage = Message::where('user_id', request()->user()->id)->get();
        if(count($checkMessage) == 0){
            $create = Message::create([
                'message' => $request->input('message'),
                'user_id' => request()->user()->id,
            ]);
            $result = new ChatsResource($create);
            event(new ChatCattery($result));
            event(new NewUserChats());
        }else{
            $create = Message::create([
                'message' => $request->input('message'),
                'user_id' => request()->user()->id,
            ]);
            $result = new ChatsResource($create);
            event(new ChatCattery($result));
        }
        
        return $this->sendResponse($result, 'Pesan Terkirim');
    }

    public function getAllUser(Request $request)
    {
        // $user = User::whereHas('messages', function($query) {
        //     $query->where('admin_id',null);
        // })->get();
        // $users = User::whereHas('messages')->with('messages')->orderBy('created_at','asc')->get();

        $users = User::whereExists(function ($query) {
            $query->select('created_at')
                ->from('messages')
                ->whereColumn('users.id', 'messages.user_id')
                ->orderBy('created_at', 'desc')
                ->limit(1);
        })->get();
        return $this->sendResponse($users,'Berhasil mendapatkan data');
    }
}
