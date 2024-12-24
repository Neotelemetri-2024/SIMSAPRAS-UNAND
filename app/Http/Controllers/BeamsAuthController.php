<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications;

class BeamsAuthController extends Controller
{
    public function auth(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $beamsClient = new PushNotifications([
                'instanceId' => env('PUSHER_BEAMS_INSTANCE_ID'),
                'secretKey' => env('PUSHER_BEAMS_SECRET_KEY'),
            ]);

            $userId = (string) auth()->id();
            $token = $beamsClient->generateToken($userId);

            return response()->json([
                'userId' => $userId,
                'token' => $token['token']
            ]);

        } catch (\Exception $e) {
            \Log::error('Beams Authentication Error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}