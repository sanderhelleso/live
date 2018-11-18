document.addEventListener('DOMContentLoaded', () => {

    // Get "navbar-burger" element
    const navbarBurger = document.querySelector('.navbar-burger');
    navbarBurger.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = document.getElementById(navbarBurger.dataset.target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        navbarBurger.classList.toggle('is-active');
        target.classList.toggle('is-active');
    });
    
});