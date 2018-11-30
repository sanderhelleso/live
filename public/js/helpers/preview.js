export const PREVIEW = {
    initAnimateCover,
    animateCover
}

let AREAS;

// add scroll event to card cover
function initAnimateCover(areas) {

    document.querySelector('#preview-body')
    .addEventListener('scroll', animateCover);

    AREAS = areas;
}

// animate preview card
function animateCover() {

    const HEIGHT = 450;
    const MAX_HEIGHT = AREAS.length * 175;
    const COVER = document.querySelector('#preview-cover');
    document.querySelector('#preview-body').style.maxHeight = `${MAX_HEIGHT}px`;
    if (this.scrollTop < MAX_HEIGHT * 1.6) {
        COVER.style.height = `${HEIGHT - this.scrollTop}px`;
    }
}