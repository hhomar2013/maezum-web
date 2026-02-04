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
        'name',
        'email',
        'password',
        'phone',
        'location',
        'fcm_token',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cheefCarts()
    {
        return $this->hasMany(cheefCart::class, 'customer_id');
    }

    public function sendPushNotification($title, $body, $data = [])
    {
        // 1. التأكد من وجود توكن
        if (empty($this->fcm_token)) {
            return false;
        }

        try {
            $messaging = Firebase::messaging();

            $message = CloudMessage::withTarget('token', $this->fcm_token)
                ->withNotification(FCMNotification::create($title, $body))
                ->withData($data)
                ->withDefaultSounds(); // ضفت لك الصوت الافتراضي مهم جداً

            $messaging->send($message);
            return true;
        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
            // 2. التوكن ده مابقاش موجود (العميل مسح التطبيق) -> امسحه من عندك
            \Log::warning("Token not found for Customer {$this->id}, deleting token.");
            $this->update(['fcm_token' => null]);
        } catch (\Exception $e) {
            // 3. أي خطأ تاني (زي مشكلة في الاتصال أو ملف الـ JSON)
            \Log::error("Firebase General Error for Customer {$this->id}: " . $e->getMessage());
        }

        return false;
    }


    public static function sendToAll($title, $body, $data = [])
    {
        // بنجيب كل العملاء اللي عندهم توكن فقط عشان مانستهلكش الرامات
        $tokens = self::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        if (empty($tokens)) {
            return "No tokens found!";
        }

        $messaging = Firebase::messaging();

        // فايربيز بيسمح ببعت مصفوفة توكنات (Multicast) بحد أقصى 500 في المرة
        // لو عدد عملائك أكبر من 500، يفضل استخدام الـ Topics أو عمل Chunk
        $message = CloudMessage::new()
            ->withNotification(FCMNotification::create($title, $body))
            ->withData($data);

        try {
            $report = $messaging->sendMulticast($message, $tokens);
            return [
                'success' => $report->successes()->count(),
                'failures' => $report->failures()->count(),
            ];
        } catch (\Exception $e) {
            \Log::error("Global Notification Error: " . $e->getMessage());
            return false;
        }
    }
}
