import { toast } from '../lib/toast.js';

export const GEO_LOCATION = {
    getLocation,
}

// fetch the location if the user position
async function getLocation() {
    if (navigator.geolocation) {
        const pos = await navigator.geolocation.getCurrentPosition(location);
        return pos;
    } 
    
    else { 
        toast('Geolocation is not supported by this browser', false, 60000);
    }
}

function location(pos) {
    return pos.coords;
}