export const PASSWORD = {
    open,
    validate
}

// open modal and ask user to enter current password
function open() {

    const modal = document.querySelector('.modal');
    modal.classList.add('is-active');

    Array.from(document.querySelectorAll('.hide-modal')).forEach(dismiss => {
        dismiss.addEventListener('click', () => {
            modal.classList.remove('is-active')
        });
    });
}

function validate() {

}