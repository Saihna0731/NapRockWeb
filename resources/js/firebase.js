import { initializeApp } from 'firebase/app';
import { child, get, getDatabase, push, ref, set } from 'firebase/database';

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    databaseURL: import.meta.env.VITE_FIREBASE_DATABASE_URL,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
};

const hasRequiredFirebaseConfig =
    firebaseConfig.apiKey &&
    firebaseConfig.projectId &&
    firebaseConfig.appId &&
    firebaseConfig.databaseURL;

let firebaseApp = null;
let firebaseDatabase = null;

if (hasRequiredFirebaseConfig) {
    firebaseApp = initializeApp(firebaseConfig);
    firebaseDatabase = getDatabase(firebaseApp);
}

export { firebaseApp, firebaseDatabase };
export { child, get, push, ref, set };
