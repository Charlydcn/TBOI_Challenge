const optionsBtn = document.querySelector('#options');
const closeBtn = document.querySelector('#close-btn');
const form = document.querySelector('#form');
const overlay = document.querySelector('#overlay');
const nextBtn = document.querySelector('#next-btn');
const step1 = document.querySelector('#step1');
const step2 = document.querySelector('#step2');
const previousBtn = document.querySelector('#previous-btn')
const submit = form.lastElementChild

// previousBtn on click : show step1 and hide step2
previousBtn.addEventListener('click', () => {
    step1.classList.remove('hidden')
    step2.classList.add('hidden')
})

// options on click : show form, step 1 and overlay
optionsBtn.addEventListener('click', () => {
    form.classList.remove('hidden');
    step1.classList.remove('hidden');
    overlay.classList.remove('hidden')
});

// closeBtn on click : hide everything
closeBtn.addEventListener('click', () => {
    hideFormAndSteps();
});

// overlay on click : hide form and reset step
overlay.addEventListener('click', (event) => {
    if (event.target === overlay) {
        hideFormAndSteps();
    }
});

// nextBtn on click : hide step1 and show step2 + show submit btn
nextBtn.addEventListener('click', () => {
    step1.classList.add('hidden');
    step2.classList.remove('hidden');
});

// close btn
closeBtn.addEventListener('click', resetAndHideForm);

// hidden on everything + step 1 not hidden
function resetAndHideForm() {
    hideFormAndSteps();
    step1.classList.remove('hidden');
}

// put hidden on everything
function hideFormAndSteps() {
    form.classList.add('hidden');
    step1.classList.add('hidden');
    step2.classList.add('hidden');
    overlay.classList.add('hidden')
}

