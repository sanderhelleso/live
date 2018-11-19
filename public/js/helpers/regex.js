export const REGEX = {
    name,
    email,
    address,
    phone,
    password
}

function name() {

    // regex to only allow alphabets and only space character between words
    // value length can also not be longer than 50 and less than 2
    const regexName = /^[a-zA-Z æøåÆØÅ ]{2,50}$/;
    return regexName;
}

function email() {

    // regex for corrext email pattern
    const regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regexEmail;
}

function address() {

    // regex for valid street address
    const regexAddress = /^\s*\S+(?:\s+\S+){2}/;
    return regexAddress;
}

function phone() {

    // regex for valid phone number
    const regexPhone = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    return regexPhone;
}

function password() {

    /*
    at least 8 characters
    at least 1 numeric character
    at least 1 lowercase letter
    at least 1 uppercase letter
    at least 1 special character
    */

    // regex for valid password
    const regexPassword = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
    return regexPassword;
}

