<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Laravel\Sanctum\HasApiTokens;

class customers extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'location', 'fcm_token',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cheefCarts()
    {
        return $this->hasMany(cheefCart::class, 'customer_id');
    }

    public function sendPushNotification($title, $body, $data = [])
    {
        if (! $this->fcm_token) {
            return;
        }
        // لو العميل معندوش توكن متبعتش حاجة

        $messaging = Firebase::messaging();

        $message = CloudMessage::withTarget('token', $this->fcm_token)
            ->withNotification(FCMNotification::create($title, $body))
            ->withData($data);

        try {
            $messaging->send($message);
        } catch (\Exception $e) {
            \Log::error("Firebase Error for Customer {$this->id}: " . $e->getMessage());
        }
    }

}
