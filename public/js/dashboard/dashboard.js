import { HEADER } from '../helpers/authHeader';

window.onload = loadUser;

async function loadUser() {

    // check if user data is allready present
    if (localStorage.getItem('user_data') !== null ) {

        const data = JSON.parse(localStorage.getItem('user_data'));

        // set users dashboard data
        document.querySelector('#nav-user-name').innerHTML = data.firstName; // navbar username

    }

    else {

        // send POST request user data endpoint and retrieve users data
        const response = await fetch('/api/dashboard/userData.php', {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
            headers: {
                ...HEADER(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify( JSON.parse(localStorage.getItem('auth_token')).id )
        });

        // get response data
        let data = await response.json();

        console.log(data);
    }
}