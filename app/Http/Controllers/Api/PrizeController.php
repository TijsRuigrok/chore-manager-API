<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function self()
    {
        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return $user->prizes;
    }

    public function store(Request $request)
    {
        $details = $request->only(['guid', 'name', 'points']);

        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        $prize = $user->prizes()->create($details);

        return $prize;
    }

    public function remove($id)
    {
        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        $user->prizes()->where('id', '=', $id)->delete();
            
        return $user->prizes;
    }

    public function claim($id)
    {
        try {
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        $prize = $user->prizes()->where('guid', '=', $id)->update(['claimed' => '1']);

        return $user->prizes;
    }
}
