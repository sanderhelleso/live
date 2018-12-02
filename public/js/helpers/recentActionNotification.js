import { toast } from '../lib/toast';

export const RECENT_ACTION = {
    didAction,
    deletedOffer,
    newOffer
}

function didAction() {
    deletedUser();
    newUser();
    loggedoutUser();
    resetedPassword();
}


function deletedOffer() {

    // if user got redirected from overview because offer was deleted,
    // display message that offer was successfully deleted
    if (localStorage.getItem('offer_deleted_successfully')) {

        // display message
        toast('Offer successfully deleted and unlisted!', true, 4000);
        localStorage.removeItem('offer_deleted_successfully');
        return true;
    }

    return false;
}

function newOffer() {

    // if user got redirected from help-offer because offer was created,
    // display message that offer was successfully created
    if (localStorage.getItem('new_offer_success')) {

        // display message
        toast('Offer successfully added and listed!', true, 4000);
        localStorage.removeItem('new_offer_success');
        return true;
    }

    return false;
}


function deletedUser() {

    // if user got redirected from dashboard because account was deleted,
    // display message and ask user to come back in the future
    if (localStorage.getItem('account_deleted_successfully')) {

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
    if (localStorage.getItem('account_created_successfully')) {

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
    if (localStorage.getItem('logout_successfull')) {

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
    if (localStorage.getItem('password_successfully_updated')) {

        // display message
        toast('Password successfully updated! You can now login with the new password', true, 4000);

        // clear localstorage
        localStorage.clear();
        return true;
    }

    return false;
}