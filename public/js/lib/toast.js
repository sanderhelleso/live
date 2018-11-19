// display a toast message
export function toast(message, type, duration) {

    // create toast
    const toast = document.createElement('div');
    toast.addEventListener('click', dismissToast);
    toast.innerHTML = `<p>${type ? '<i data-feather="check-circle">' : '<i data-feather="x-circle">'}</i> ${message}</p>`;
    toast.className = `toast toast-${type ? 'success' : 'error'} animated fadeInUp`;

    // set toast and start timeout
    document.querySelector('main').appendChild(toast);
    feather.replace();
    const dismiss = setTimeout(() => {
        dismissToast();
    }, duration);

    // dissmiss toast after duration or on click
    function dismissToast() {
        window.clearTimeout(dismiss);
        toast.classList.remove('fadeInUp');
        toast.classList.add('fadeOutUp');
        setTimeout(() => {
            document.querySelector('main').removeChild(toast);
        }, 500);
    }
}