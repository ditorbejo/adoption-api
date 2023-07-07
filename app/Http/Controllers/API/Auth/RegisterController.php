<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email'=> $request->email,
                'password' => bcrypt($request->password),
            ]
            );
        $data = new UserResource($user);
        return $this->sendResponse($data, 'User registered');
    }
}
