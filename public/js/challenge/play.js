// ---------------------------------------------------------------------------------------------------
// WIN/LOOSE SCRIPT ----------------------------------------------------------------------------------

// = challenge win-streak : <p>
const challengeStreak = document.getElementById('challenge-streak')
 // user win-streak : <div>..<p>
const winCounter = document.querySelector("#win-counter p")
// <div id="btns"> containing WIN & LOOSE btns
const btnsDiv = document.getElementById("btns")
// <div id="completion-time"> containing playChallenge creation form (for completion time)
const completionTimeForm = document.getElementById("completion-time")

let count = 0

function increment() {
    // if challenge has a win-streak condition
    if (challengeStreak.textContent > 0) {
        
        // show win-streak div (flame.webp + counter)
        if (winCounter.parentElement.classList.contains('hidden')) {
            winCounter.parentElement.classList.remove('hidden')
        }

        // if user win-streak isn't enough to win the challenge
        if (winCounter.textContent !== challengeStreak.textContent) {
            // increment user win-streak and refresh #win-counter p textContent
            count++
            winCounter.textContent = count
        }

        // if user win-streak match the challenge win-streak condition
        if (count >= challengeStreak.textContent) {
            // call CompletionTime() to show completion time input
            showCompletionTime()
        }

    // else, call CompletionTime() to show completion time input (user won, no win-streak so no multiple runs needed)
    } else {
        showCompletionTime()
    }
}

function showCompletionTime() {
    // hide btns (WIN & LOOSE)
    btnsDiv.classList.add('hidden')

    // show completion time input
    completionTimeForm.classList.remove('hidden')

}

function showBtns() {
    // show btns (WIN & LOOSE)
    btnsDiv.classList.remove('hidden')

    // hide completion time input
    completionTimeForm.classList.add('hidden')
}


// ---------------------------------------------------------------------------------------------------
// REVEAL RESULT / GO BACK TO WIN/LOOSE BTNS ---------------------------------------------------------

const playBtn = document.querySelector('.play-btn')
const backBtn = document.querySelector('.back-btn')
const step1 = document.querySelector('#step1')
const step2 = document.querySelector('#step2')

playBtn.addEventListener('click', () => {
    step1.classList.add('hidden')
    step2.classList.remove('hidden')
})

backBtn.addEventListener('click', () => {
    step2.classList.add('hidden')
    step1.classList.remove('hidden')
})
