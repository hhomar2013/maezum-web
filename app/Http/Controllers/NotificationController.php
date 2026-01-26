<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function sendNotification($fcmToken)
    {
        $messaging = app('firebase.messaging');
        
        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification(Notification::create(
                env("APP_NAME"),
                "رساله يا عم"
            ));

        try {
            $messaging->send($message);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}