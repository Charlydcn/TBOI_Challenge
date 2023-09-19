const optionsBtn = document.querySelector('#options')
const closeBtn = document.querySelector('#close-btn')
const form = document.querySelector('#form')
const overlay = document.querySelector('#overlay')
const nextBtn = document.querySelector('#next-btn')
const step1 = document.querySelector('#step1')
const step2 = document.querySelector('#step2')
const previousBtn = step2.querySelector('#restrictions h2')
const submit = document.querySelector('#challenge_submit')

// OPEN MENU (options on click : show form, step 1 and overlay)
optionsBtn.addEventListener('click', () => {
    form.classList.remove('hidden')
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

// SHOW STEP 2 (nextBtn on click : hide step1 and show step2 + show submit btn)
nextBtn.addEventListener('click', () => {
    step1.classList.add('hidden')
    step2.classList.remove('hidden')
    submit.classList.remove('hidden')
})

// GO BACK TO STEP 1 FROM STEP 2 (previousBtn on click : show step1 and hide step2)
previousBtn.addEventListener('click', () => {
    step1.classList.remove('hidden')
    step2.classList.add('hidden')
    submit.classList.add('hidden')
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
    submit.classList.add('hidden')
}

// put hidden on everything
function hideFormAndSteps() {
    form.classList.add('hidden')
    step1.classList.add('hidden')
    step2.classList.add('hidden')
    overlay.classList.add('hidden')
    submit.classList.remove('hidden')
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
