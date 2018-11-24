import { toast } from '../lib/toast';

export const RECENT_ACTION = {
    didAction
}

function didAction() {
    deletedUser();
    newUser();
    loggedoutUser();
    resetedPassword();
}


function deletedUser() {

    // if user got redirected from dashboard because account was deleted,
    // display message and ask user to come back in the future
    if (localStorage.getItem('account_deleted_successfully') !== null) {

        // display message
        toast('We are sad to see you go! Hope to see you again in the future', true, 4000);

        // clear localstorage
        localStorage.clear();
        return true;
    }

    return false;
}

function newUser() {

    // if user got redirected from sign up,
    // display message and ask to login with credentials
    if (localStorage.getItem('account_created_successfully') !== null) {

        // display message
        toast(`Welcome to LIVE ${localStorage.getItem('account_created_successfully')}! Please login to continue`, true, 4000);

        // clear localstorage
        localStorage.clear();
        return true;
    }

    return false;
}

function loggedoutUser() {

    // if user got redirected from successfull logout,
    // display message and welcome back the user
    if (localStorage.getItem('logout_successfull') !== null) {

        // display message
        toast('Logout successfull! Hope to see you again soon', true, 4000);

        // clear localstorage
        localStorage.clear();
        return true;
    }

    return false;
}

function resetedPassword() {

    // if user got redirected from successfull reset password,
    // display message and tell user to login with new password
    if (localStorage.getItem('password_successfully_updated') !== null) {

        // display message
        toast('Password successfully updated! You can now login with the new password', true, 4000);

        // clear localstorage
        localStorage.clear();
        return true;
    }

    return false;
}