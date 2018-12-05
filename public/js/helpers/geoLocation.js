import { toast } from '../lib/toast.js';

export const GEO_LOCATION = {
    getLocation,
}

// fetch the location if the user position
function geo() {

    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
    });
}

async function getLocation() {
    if (navigator.geolocation) {
        const pos = await geo();
        return pos.coords;
    } 
    
    else { 
        toast('Geolocation is not supported by this browser', false, 60000);
    }
}