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
// INFOS BOX ON HOVER (RESTRICTIONS) -----------------------------------------------------------------

// restrictions icon : <div id="restrictions">..<div>..<img>
const restrictionsImgs = document.querySelectorAll('#restrictions div img')
// infos box : <div class="hover-infos">
const hoverInfos = document.querySelectorAll(".hover-infos")

// for restriction img
restrictionsImgs.forEach(restrictionImg => {
    // when clicked,
    restrictionImg.addEventListener('click', () => {

        // hide every infos box (hoverInfos) 
        hoverInfos.forEach(infos => {
            // except for the closest hoverInfos from the restriction img that user clicked on, structure:
            // <div>..<img> ~ <div class="hover-infos">..</div> 
            if(infos !== restrictionImg.nextElementSibling) {
                infos.classList.add('hidden')
            }
        })

        // show/hide closest infos box (hoverInfos) from the restriction img that user clicked on
        restrictionImg.nextElementSibling.classList.toggle('hidden')
    })
})

// if user click anywhere on the document
document.addEventListener('click', (event) => {
    // as long as it's not '.hover-infos' and not #restrictions
    if (!event.target.classList.contains('hover-infos') && !event.target.closest('#restrictions')) {
        // hide all hoverInfos
        hoverInfos.forEach(info => {
            info.classList.add('hidden')
        })
    }
})
