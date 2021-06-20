importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');
   
	firebase.initializeApp({
        apiKey: "AIzaSyDocWgEMLHp5WjtMtgPryQDECgA24mQHl0",
        authDomain: "saydalizone.firebaseapp.com",
        projectId: "saydalizone",
        storageBucket: "saydalizone.appspot.com",
        messagingSenderId: "1014551233533",
        appId: "1:1014551233533:web:8a64e825a1efdba57d8f94",
        measurementId: "G-0ZRL6FBP0Q"
    });

	const messaging = firebase.messaging();
	messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
        
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});