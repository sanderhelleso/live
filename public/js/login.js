import { toast } from './lib/toast';
import { REGEX } from './helpers/regex';

window.onload = initializeForm;

function initializeForm() {

    // check if user recently signed up and got redirected from sign up page
    newUser();

    // initialize "login" button with login event
    document.querySelector('#login-btn').addEventListener('click', login);
}

function newUser() {

     // if user got redirected from sign up,
    // display message and ask to login with credentials
    if (localStorage.getItem('account_created_successfully') !== null) {

        // display message
        toast(`Welcome to LIVE ${localStorage.getItem('account_created_successfully')}! Please login to continue`, true, 4000);

        // clear localstorage
        localStorage.clear();
    }
}

function login(e) {

    // prevent page from reloading
    e.preventDefault();

    // clear and reset forms previous messages
    clearForm();

    const email = validateEmail();
    const password = validatePassword();

    // validate inputed email and password
    if (email && password) {
        
        // attempt login with given credentials
        attemptLogin(email, password, e.target);
    }
}

async function attemptLogin(email, password, button) {

    // set loading status
    button.classList.add('is-loading');

    // send POST request login endpoint
    const response = await fetch('/api/login/login.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email,
            password,
            rememberMe: document.querySelector('input[type="checkbox"]').checked
        })
    });

    // get response data
    let data = await response.json();

    // validate response
    if (data.success) {

        // set auth_token depending on "remember me" is checked
        if (document.querySelector('input[type="checkbox"]').checked) {
            localStorage.setItem('auth_token', JSON.stringify(data.token));
        }

        else {
            sessionStorage.setItem('auth_token', JSON.stringify(data.token));
        }

        // redirect user
        window.location.replace('/dashboard/dashboard.php');
    }

    else {

        // dispplay response message
        toast(data.message, data.success, 3000);
        setTimeout(() => {
            button.classList.remove('is-loading');
        }, 1000);
    }
}

function validateEmail() {

    // fetch email input
    const email = document.querySelector('input[type="email"');

    // validate email value with regex
    if (!REGEX.email().test(String(email.value).toLowerCase())) {    

        // if email format is invalid, set error message and state
        email.classList.add('is-danger');
        document.querySelector('.email-help').innerHTML = 'Invalid E-Mail format';
        return false;
    }
      
    // email is valid
    email.classList.add('is-primary');
    return email.value;
}

function validatePassword() {

    // fetch password input
    const password = document.querySelector('input[type="password"');

    // check if password is empty
    if (!password.value) {

        // if password is empty set error message and state
        password.classList.add('is-danger');
        document.querySelector('.password-help').innerHTML = 'Password cant be empty';
        return false;
    }

    // password is filled in
    password.classList.add('is-primary');
    return password.value;
}

function clearForm() {

    // reset input states
    Array.from(document.querySelectorAll('.login-input')).forEach(input => {
        input.className = 'input is-rounded is-medium login-input';
    });

    // reset error messages
    Array.from(document.querySelectorAll('.help')).forEach(message => {
        message.innerHTML = '';
    });

}