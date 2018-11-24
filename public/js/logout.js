export const LOGOUT = async () => {

    // send POST request logout endpoint
    const response = await fetch('/api/logout/logout.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: JSON.parse(localStorage.getItem('auth_token')).id
        })
    });

    // get response
    const data = await response.json();

    // validate logout
    if (data.success) {

        // clear localstorage and logout user
        localStorage.clear();

        // set welcome back message
        localStorage.setItem('logout_successfull', true);

        // redirect user
        window.location.replace('/login');
    }
};