const overlay = document.querySelector('#overlay')
const nextBtn = document.querySelector('#next-btn')
const step1 = document.querySelector('#step1')
const step2 = document.querySelector('#step2')
const previousBtn = step2.querySelector('#restrictions h2')
const endBtns = document.querySelector('#end-btns')
const howToPlayBtns = document.querySelectorAll('.howtoplay-btn')
const howToPlay = document.querySelector('#howtoplay')
const closeBtn = document.querySelector('#howtoplay figcaption p')

// display tutorial on how to play btn click
howToPlayBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        howToPlay.classList.remove('hidden')
        overlay.classList.remove('hidden')
    })
})

// close on X btn click
closeBtn.addEventListener('click', () => {
    console.log('test')
    howToPlay.classList.add('hidden')
    overlay.classList.add('hidden')
})

// close on overlay click
overlay.addEventListener('click', (event) => {
    if (event.target === overlay) {
        howToPlay.classList.add('hidden')
        overlay.classList.add('hidden')
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
            step2.style.display = "flex";
            endBtns.style.display = "flex";
        }
})

if (window.innerWidth >= 991) {
    // GO BACK TO STEP 1 FROM STEP 2 (previousBtn on click : show step1 and hide step2)
    // (only if on mobile)
    previousBtn.addEventListener('click', () => {
    
    step1.classList.remove('hidden')
    step2.classList.add('hidden')
    endBtns.classList.add('hidden')
    })      
} else {
    previousBtn.style.cursor = "unset"
    previousBtn.firstElementChild.style.display = "none"
}