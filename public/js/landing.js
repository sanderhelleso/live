window.onload = initialize;

// globals
var previousPosition = window.pageYOffset || document.documentElement.scrollTop;

function initialize() {
    console.log(123);
    window.addEventListener('scroll', scrollSpy);
}

function scrollSpy(e) {
    var navbar = document.querySelector('#main-navbar')
    var currentPosition = window.pageYOffset || document.documentElement.scrollTop;

    if (previousPosition > currentPosition) {
        navbar.className = 'navbar is-fixed-top box animated slideInDown';
    } 
    
    else {
        navbar.className = 'navbar is-fixed-top box animated slideOutUp'
    }

    previousPosition = currentPosition;
}