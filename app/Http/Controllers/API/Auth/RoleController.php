<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $role = request()->user()->role;
        return response()->json([
            'role'=>$role,
        ]);
    }
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
}
