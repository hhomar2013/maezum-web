// Import the Firebase scripts
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

// Initialize Firebase
firebase.initializeApp({
    apiKey: "AIzaSyApPYyToFcBou9IfL--plTvKSnO6efTNxk",
    authDomain: "talabety-9e7de.firebaseapp.com",
    projectId: "talabety-9e7de",
    storageBucket: "talabety-9e7de.firebasestorage.app",
    messagingSenderId: "1083111806635",
    appId: "1:1083111806635:web:e2211d8d60a02454bac9ee"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon || '/logo.png'
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});
