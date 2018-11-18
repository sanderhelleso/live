window.onload = initialize;

// globals
let previousPosition = window.pageYOffset || document.documentElement.scrollTop;

function initialize() {
    window.addEventListener('scroll', scrollSpy);
}

function scrollSpy() {
    const navbar = document.querySelector('#main-navbar');
    const currentPosition = window.pageYOffset || document.documentElement.scrollTop;

    // fade in elements when scrolled past
    Array.from(document.querySelectorAll('.section')).forEach(section => {
        if (window.scrollY > (section.offsetTop - 400)) {
            section.style.opacity = '1';
        }
    });
    
    // animate navigation bar depending on scroll direction
    if (currentPosition !== 0) {
        if (previousPosition > currentPosition) {
            navbar.className = 'navbar is-fixed-top box animated slideInDown';
        } 
        
        else {
            navbar.className = 'navbar is-fixed-top box animated slideOutUp'
        }
    }

    previousPosition = currentPosition;
}