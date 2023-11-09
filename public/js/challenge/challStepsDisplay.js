const optionsBtn = document.querySelector('#options')
const closeBtn = document.querySelector('#close-btn')
const formDiv = document.querySelector('#form')
const overlay = document.querySelector('#overlay')
const nextBtn = document.querySelector('#next-btn')
const step1 = document.querySelector('#step1')
const step2 = document.querySelector('#step2')
const previousBtn = step2.querySelector('#restrictions h2')
const endBtns = document.querySelector('#end-btns')

// OPEN MENU (options on click : show form, step 1 and overlay)
optionsBtn.addEventListener('click', () => {
    formDiv.classList.remove('hidden')
    step1.classList.remove('hidden')
    overlay.classList.remove('hidden')
})

// CLOSE MENU (closeBtn/overlay on click : hide form and reset step)
// close on X btn click
closeBtn.addEventListener('click', () => {
    hideFormAndSteps()
})

// close on overlay click
overlay.addEventListener('click', (event) => {
    if (event.target === overlay) {
        hideFormAndSteps()
    }
})

// SHOW STEP 2 on nextBtn click IF user selected atleast 1 character and 1 boss
nextBtn.addEventListener('click', (event) => {
        // get the amount of characters input checked
        var charactersCount = form.querySelectorAll('#characters .list label input:checked').length
        // get the amount of bosses input checked
        var bossesCount = form.querySelectorAll('#bosses .list label input:checked').length

        // if user selected less than 1 character, don't show step 2 and alert()
        if (charactersCount < 1) {
            event.preventDefault()
            alert('You have to select at least 1 character')

        // if user selected less than 1 boss, don't show step 2 and alert()
        } else if (bossesCount < 1) {
            event.preventDefault()
            alert('You have to select at least 1 boss')

        // if user selected atleast 1 boss and 1 character, hide step 1, show step 2 and endBtns
        } else {
            step1.classList.add('hidden')
            step2.classList.remove('hidden')
            endBtns.classList.remove('hidden')
        }
})

// GO BACK TO STEP 1 FROM STEP 2 (previousBtn on click : show step1 and hide step2)
previousBtn.addEventListener('click', () => {
    step1.classList.remove('hidden')
    step2.classList.add('hidden')
    endBtns.classList.add('hidden')
})

// CLOSE MENU
closeBtn.addEventListener('click', resetAndHideForm)

// -----------------------------------------------------------------------------------------
// FUNCTIONS -------------------------------------------------------------------------------
// hidden on everything + step 1 not hidden
// -----------------------------------------------------------------------------------------
function resetAndHideForm() {
    hideFormAndSteps()
    step1.classList.remove('hidden')
    endBtns.classList.add('hidden')
}

// put hidden on everything
function hideFormAndSteps() {
    formDiv.classList.add('hidden')
    step1.classList.add('hidden')
    step2.classList.add('hidden')
    overlay.classList.add('hidden')
    endBtns.classList.remove('hidden')
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
