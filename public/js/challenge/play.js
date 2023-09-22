// win counter script --------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------

// set count to 0
let count = 0
const challengeStreak = document.getElementById('challenge-streak')
const winCounter = document.querySelector("#win-counter p")


function increment() {
    // +1 to count
    count++

    // update counter text
    winCounter.textContent = count

    // check if current win-streak is enough to win the challenge
    checkCount()

    // remove class hidden of win-streak div when user won atleast 1 time
    if (winCounter.parentElement.classList.contains('hidden')) {
        winCounter.parentElement.classList.remove('hidden')
    }
}

function checkCount() {
    // if nb of user completion of the challenge match the required challenge win-streak
    if (count >= challengeStreak.textContent) {
        // if so, redirect by getting the data-href in winCounter parent div
        var url = winCounter.parentElement.getAttribute('data-href')
        window.location.href = url
    }
}
