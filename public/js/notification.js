// في ملف notifications.js أو أي ملف frontend JavaScript
async function sendSampleNotification(fcmToken) {
    try {
        const response = await fetch('/api/send-notification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('fcm_token')}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                token: fcmToken,
                title: "إشعار تجريبي",
                body: "هذا اختبار لإرسال الإشعارات"
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to send notification');
        }
        
        console.log('تم إرسال الإشعار بنجاح:', data);
        alert('تم إرسال الإشعار بنجاح!');
        return data;
    } catch (error) {
        console.error('خطأ في إرسال الإشعار:', error);
        alert(`خطأ: ${error.message}`);
        throw error;
    }
}

// اجعلها متاحة للاستخدام من أي مكان
window.sendSampleNotification = sendSampleNotification;