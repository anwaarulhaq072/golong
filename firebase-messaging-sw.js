// console.log("working")
importScripts('https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js')
importScripts('https://www.gstatic.com/firebasejs/8.2.2/firebase-messaging.js')
const firebaseConfig = {
    apiKey: "AIzaSyCUm5YstkPOVFrTQc6o2hZapMoHIs1Xu8c",
    authDomain: "golong-a9f80.firebaseapp.com",
    projectId: "golong-a9f80",
    storageBucket: "golong-a9f80.appspot.com",
    messagingSenderId: "478342696383",
    appId: "1:478342696383:web:ecbd6ea04173185e0d250a",
    measurementId: "G-5Y2EDPRZ2M"
};
firebase.initializeApp(firebaseConfig);

const fcm = firebase.messaging();
fcm.getToken({
    vapidkey: 'BNCB1JiZQsmEfvRP9PJ0xyTMZ-pjkYK-X7apLpFOekF1iClIFQMTufbXy_YziRJ7AFkNNEqN8EgKLIETnbBvbF8' 
}).then((token)=>{
    console.log('TOken: => ' , token)
})
// fcm.onBackgroundMessage((data)=>{
//     console.log('back MEssage ' , data) ;
// })