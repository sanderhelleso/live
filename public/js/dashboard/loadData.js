import { toast } from '../lib/toast.js';
import { HEADER } from '../helpers/authHeader.js';

export const DATA = {
    loadUserData,
    loadOfferData,
    setNavbarData,
    setAvatar,
    setName,
    setFirstName
}

async function loadOfferData() {

     // send POST request offer data endpoint and retrieve offer data
     const response = await fetch('/api/user/get-offer-data.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            ...HEADER(),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: JSON.parse(localStorage.getItem('auth_token')).id
        })
    });

    // get response data
    let data = await response.json();

    if (data.success) {
        // clean up data
        delete data.payload.help_id;
        delete data.payload.user_id;

        // store offer data in localstorage
        localStorage.setItem('offer_data', JSON.stringify(data.payload));

        // display stats
        document.querySelector('#overview-cont').className = 'container animated fadeIn';
        document.querySelector('#overview-cont').style.display = 'block';
        return;
    }

    window.location.replace('/dashboard/offer-help');

}

async function loadUserData() {

    // check if user data is allready present
    if (localStorage.getItem('user_data') !== null ) {

        const data = JSON.parse(localStorage.getItem('user_data'));
        return data;
    }

    else {

        // send POST request user data endpoint and retrieve users data
        const response = await fetch('/api/user/get-user-data.php', {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
            headers: {
                ...HEADER(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: JSON.parse(localStorage.getItem('auth_token')).id
            })
        });

        // get response data
        let data = await response.json();

        // successfully retrieved user data
        if (data.success) {
            localStorage.setItem('user_data', JSON.stringify(data.payload));
            return data.payload;
        }

        // unable to retrieve data, display message to user
        else {
            toast(data.message, data.success, 3000);
        }
    }
}

function setName(data, ele) {

    // set users full name
    document.querySelector(`#${ele}`).innerHTML = `${data.first_name} ${data.last_name}`;
}

function setFirstName(data, ele) {

    // set users first name
    document.querySelector(`#${ele}`).innerHTML = `${data.first_name}`;
}

// set users navbar data
function setNavbarData(data) {

    // navbar username
    document.querySelector('#nav-user-name').innerHTML = data.email;

    // set avatar
    const avatar = document.querySelector('#user-avatar');
    setAvatar(avatar, data);

    document.querySelector('#nav-user').style.display = 'block';
}

function setAvatar(image, data) {
    const defaultAvatar = `${location.protocol}//${location.host}/public/img/dashboard/defaultAvatar.jpg`;
    image.src = data.avatar ? `data:image/png;base64,${data.avatar}` : defaultAvatar;
    image.alt = `${data.first_name} ${data.last_name}'s avatar`;

    return defaultAvatar;
}