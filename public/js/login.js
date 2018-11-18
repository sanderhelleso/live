window.onload = initializeForm;

// regex pattern for email validation
const regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

function initializeForm() {

    // if credentials is stored in localstorage (remember me), retrieve and set
    if (localStorage.getItem('credentials')) {

        // parse credentials
        const credentials = JSON.parse(localStorage.getItem('credentials'));

        // set email credential
        document.querySelector('input[type="email"').value = credentials.email;

        // set password credential
        document.querySelector('input[type="password"').value = credentials.password;

        // set checkbox to checked
        document.querySelector('input[type="checkbox"]').checked = true;
    }

    // initialize "login" button with login event
    document.querySelector('#login-btn').addEventListener('click', login);
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
    const response = await fetch('/api/login.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            payload: {
                email,
                password
            }
        })
    });

    console.log(response);

    // login successfull
    if (response.status === 200) {
        console.log('login successfull');

        // set username and password in localstorage if option is checked
        if (document.querySelector('input[type="checkbox"]').checked) {
            localStorage.setItem('credentials', JSON.stringify({
                email, 
                password
            }));
        }

        // redirect user
        //window.location.replace('/dashboard/dashboard.php');
    }

    // login failed
    else {
        console.log('login failed');
    }

    // simulate request with db loading
    setTimeout(() => {
        button.classList.remove('is-loading');
    }, 1000);
}

function validateEmail() {

    // fetch email input
    const email = document.querySelector('input[type="email"');

    // validate email value with regex
    if (!regexEmail.test(String(email.value).toLowerCase())) {    

        // if email format is invalid, set error message and state
        email.classList.add('is-danger');
        document.querySelector('.email-help').innerHTML = 'Invalid e-mail format';
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