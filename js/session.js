// Session Storage Hilfsfunktionen
function saveToSessionStorage(key, data){
    try {
        sessionStorage.setItem(key, JSON.stringify(data));
        return true;
    } catch(e) {
        console.error('Fehler beim Speichern:', e);
        return false;
    }
}

function getFromSessionStorage(key){
    try {
        let data = sessionStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch(e) {
        console.error('Fehler beim Laden:', e);
        return null;
    }
}

function removeFromSessionStorage(key){
    try {
        sessionStorage.removeItem(key);
        return true;
    } catch(e) {
        console.error('Fehler beim Löschen:', e);
        return false;
    }
}

// Local Storage Hilfsfunktionen
function saveToLocalStorage(key, data){
    try {
        localStorage.setItem(key, JSON.stringify(data));
        return true;
    } catch(e) {
        console.error('Fehler beim Speichern:', e);
        return false;
    }
}

function getFromLocalStorage(key){
    try {
        let data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch(e) {
        console.error('Fehler beim Laden:', e);
        return null;
    }
}

function removeFromLocalStorage(key){
    try {
        localStorage.removeItem(key);
        return true;
    } catch(e) {
        console.error('Fehler beim Löschen:', e);
        return false;
    }
}