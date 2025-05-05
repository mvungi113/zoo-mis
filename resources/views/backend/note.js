// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyC1xwzo3QBVTKrvvLXHg35HhyR1EoGIfPI",
  authDomain: "zoomisapi.firebaseapp.com",
  databaseURL: "https://zoomisapi-default-rtdb.firebaseio.com",
  projectId: "zoomisapi",
  storageBucket: "zoomisapi.firebasestorage.app",
  messagingSenderId: "1075730501303",
  appId: "1:1075730501303:web:685034df168130ab2e8732",
  measurementId: "G-4914V3BC0N"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);