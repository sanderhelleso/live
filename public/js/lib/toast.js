// display a toast message
export function toast(message, type, duration) {
    console.log(message, type, duration);

    const toast = document.createElement('div');
    toast.innerHTML = `<p>${message}</p>`;
    toast.className = `toast toast-${type ? 'success' : 'error'}`;

    document.querySelector('main').appendChild(toast);
    setTimeout(() => {
        document.body.removeChild(toast);
    }, 60000);
}