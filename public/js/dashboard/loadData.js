import { toast } from '../lib/toast';
import { HEADER } from '../helpers/authHeader';

export const DATA = {
    loadUserData,
    setNavbarData,
    setAvatar,
    setName
}

async function loadUserData() {

    // check if user data is allready present
    if (localStorage.getItem('user_data') !== null ) {

        const data = JSON.parse(localStorage.getItem('user_data'));
        return data;
    }

    else {

        // send POST request user data endpoint and retrieve users data
        const response = await fetch('/api/user/getUserData.php', {
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

function setName(data) {

    // set users full name
    document.querySelector('#user-settings-name').innerHTML = `${data.first_name} ${data.last_name}`;
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
    image.src = data.avatar ? `data:image/png;base64,${data.avatar}` : `${location.protocol}//${location.host}/public/img/dashboard/defaultAvatar.jpg`;
    image.alt = `${data.first_name} ${data.last_name}'s avatar`;
}