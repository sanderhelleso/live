export const WORDS = {
    getRandomWord
}

// words array
const WORDS_ARR = ['Great', 'Awesome', 'Amazing', 'Cool', 'Nice', 'Great', 'Wonderful', 'Sweet'];

// pick random word from array
function getRandomWord() {
    return WORDS_ARR[Math.floor(Math.random() * WORDS_ARR.length - 1) + 1];
}