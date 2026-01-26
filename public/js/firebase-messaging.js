// // public/js/firebase-messaging.js

// // 1. تهيئة Firebase
// const firebaseConfig = {
//     apiKey: "AIzaSyApPYyToFcBou9IfL--plTvKSnO6efTNxk",
//     authDomain: "talabety-9e7de.firebaseapp.com",
//     projectId: "talabety-9e7de",
//     storageBucket: "talabety-9e7de.appspot.com",
//     messagingSenderId: "1083111806635",
//     appId: "1:1083111806635:web:e2211d8d60a02454bac9ee"
//   };
  
//   // 2. استبدل بالمفتاح الفعلي من Firebase Console
//   const VAPID_KEY = "BGidPhjxaOo1tP-B21EVeOocxtaaHafaRLNu7LhbDf6OSglc28kIH4MC6QKwBDL0qMsy60bf1sK6vwvtmT3UzEc";
  
//   // 3. دالة إرسال التوكن للخادم
//   async function sendTokenToServer(token) {
//     try {
//       const response = await fetch('/api/save-fcm-token', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json',
//           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//         },
//         body: JSON.stringify({ fcm_token: token })
//       });
//       if (!response.ok) throw new Error('Failed to save token');
//       console.log('Token saved successfully');
//     } catch (error) {
//       console.error('Error saving token:', error);
//     }
//   }
  
//   // 4. تهيئة FCM
//   async function initializeFCM() {
//     // التحقق من دعم المتصفح
//     if (!('serviceWorker' in navigator) || !('Notification' in window)) {
//       console.error('Browser does not support notifications');
//       return;
//     }
  
//     try {
//       // تسجيل Service Worker
//       const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
//       console.log('Service Worker registered');
  
//       // تهيئة Firebase
//       const app = firebase.initializeApp(firebaseConfig);
//       const messaging = firebase.messaging(app);
//       messaging.useServiceWorker(registration);
  
//       // طلب الإذن والحصول على التوكن
//       const permission = await Notification.requestPermission();
//       if (permission === 'granted') {
//         const token = await messaging.getToken({ vapidKey: VAPID_KEY });
//         console.log('FCM Token:', token);
//         await sendTokenToServer(token);
//       }
  
//       // استقبال الإشعارات
//       messaging.onMessage((payload) => {
//         console.log('Message received:', payload);
//         new Notification(payload.notification.title, {
//           body: payload.notification.body,
//           icon: '/logo.png'
//         });
//       });
  
//     } catch (error) {
//       console.error('FCM Initialization Error:', error);
//     }
//   }
  
//   // 5. التشغيل عند تحميل الصفحة
//   document.addEventListener('DOMContentLoaded', initializeFCM);



// public/js/firebase-messaging.js

// 1. تهيئة Firebase
const firebaseConfig = {
    apiKey: "AIzaSyApPYyToFcBou9IfL--plTvKSnO6efTNxk",
    authDomain: "talabety-9e7de.firebaseapp.com",
    projectId: "talabety-9e7de",
    storageBucket: "talabety-9e7de.appspot.com",
    messagingSenderId: "1083111806635",
    appId: "1:1083111806635:web:e2211d8d60a02454bac9ee"
  };
  
  // استبدل بالمفتاح الفعلي من Firebase Console
  const VAPID_KEY = "BGidPhjxaOo1tP-B21EVeOocxtaaHafaRLNu7LhbDf6OSglc28kIH4MC6QKwBDL0qMsy60bf1sK6vwvtmT3UzEc";
  
  // 2. تهيئة التطبيق
  const app = firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging(app);
  
  // 3. دالة الحصول على FCM Token
  async function getFCMToken() {
    try {
      // التحقق من دعم المتصفح
      if (!('Notification' in window)) {
        throw new Error('المتصفح لا يدعم الإشعارات');
      }
  
      // طلب الإذن
      const permission = await Notification.requestPermission();
      if (permission !== 'granted') {
        throw new Error('تم رفض إذن الإشعارات');
      }
  
      // الحصول على التوكن
      const currentToken = await messaging.getToken({ 
        vapidKey: VAPID_KEY,
        serviceWorkerRegistration: await navigator.serviceWorker.ready
      });
  
      if (!currentToken) {
        throw new Error('فشل الحصول على التوكن');
      }
  
      console.log('FCM Token:', currentToken);
      return currentToken;
    } catch (error) {
      console.error('خطأ في الحصول على التوكن:', error);
      throw error;
    }
  }
  
  // 4. دالة إرسال التوكن للخادم
  async function sendTokenToServer(token) {
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
      if (!csrfToken) throw new Error('CSRF token غير موجود');
  
      const response = await fetch('/api/save-fcm-token', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Authorization': `Bearer ${localStorage.getItem('auth_token') || ''}`
        },
        body: JSON.stringify({ fcm_token: token })
      });
  
      if (!response.ok) throw new Error('فشل حفظ التوكن');
      
      console.log('تم حفظ التوكن في الخادم');
      localStorage.setItem('fcm_token', token);
      return true;
    } catch (error) {
      console.error('خطأ في إرسال التوكن:', error);
      throw error;
    }
  }
  
  // 5. دالة حذف التوكن
  async function deleteFCMToken() {
    try {
      const token = await messaging.getToken();
      if (token) {
        await messaging.deleteToken(token);
      }
      localStorage.removeItem('fcm_token');
      console.log('تم حذف التوكن');
      return true;
    } catch (error) {
      console.error('خطأ في حذف التوكن:', error);
      throw error;
    }
  }
  
  // 6. دالة إرسال إشعار تجريبي
  async function sendTestNotification() {
    try {
      const token = localStorage.getItem('fcm_token');
      if (!token) throw new Error('لا يوجد FCM Token');
  
      const response = await fetch('/api/send-test-notification', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ token })
      });
  
      if (!response.ok) throw new Error('فشل إرسال الإشعار');
      
      console.log('تم إرسال الإشعار التجريبي');
      return true;
    } catch (error) {
      console.error('خطأ في إرسال الإشعار:', error);
      throw error;
    }
  }
  
  // 7. تهيئة Service Worker
  async function initializeServiceWorker() {
    try {
      if (!('serviceWorker' in navigator)) {
        throw new Error('المتصفح لا يدعم Service Workers');
      }
  
      const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
      console.log('Service Worker مسجل بنجاح:', registration.scope);
      
      messaging.useServiceWorker(registration);
      return registration;
    } catch (error) {
      console.error('فشل تسجيل Service Worker:', error);
      throw error;
    }
  }
  
  // 8. إعداد استقبال الإشعارات
  function setupMessageHandlers() {
    // استقبال الإشعارات عند فتح التطبيق
    messaging.onMessage((payload) => {
      console.log('تم استقبال إشعار:', payload);
      
      new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon || '/logo.png'
      });
    });
  
    // تحديث التوكن عند التغيير
    messaging.onTokenRefresh(async () => {
      try {
        const newToken = await getFCMToken();
        await sendTokenToServer(newToken);
      } catch (error) {
        console.error('خطأ في تحديث التوكن:', error);
      }
    });
  }
  
  // 9. تهيئة كاملة لـ FCM
  async function initializeFCM() {
    try {
      await initializeServiceWorker();
      setupMessageHandlers();
      
      const token = await getFCMToken();
      await sendTokenToServer(token);
      
      console.log('تم تهيئة FCM بنجاح');
      return true;
    } catch (error) {
      console.error('فشل تهيئة FCM:', error);
      return false;
    }
  }
  
  // 10. التشغيل عند تحميل الصفحة
  document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('meta[name="fcm-enabled"]')) {
      initializeFCM().catch(console.error);
    }
  });
  
  // جعل الدوال متاحة للاستخدام من أي مكان
  window.FCM = {
    getToken: getFCMToken,
    sendTestNotification,
    deleteToken: deleteFCMToken,
    initialize: initializeFCM
  };