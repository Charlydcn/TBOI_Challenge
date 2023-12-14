const overlay = document.querySelector('#overlay')
const nextBtn = document.querySelector('#next-btn')
const step1 = document.querySelector('#step1')
const step2 = document.querySelector('#step2')
const previousBtn = step2.querySelector('#restrictions h2')
const endBtns = document.querySelector('#end-btns')
const howToPlayBtns = document.querySelectorAll('.howtoplay-btn')
const howToPlay = document.querySelector('#howtoplay')
const closeBtn = document.querySelector('#howtoplay figcaption p')
const randomizerForm = document.querySelector('#form form')

// for mobile, howToPlay btn behavior changes, and nextBtn too
if (window.innerWidth <= 991) {
    // ----------------------------------------------------------------------------------------
    // --------- howToPlayBtn -----------------------------------------------------------------
    howToPlayBtns.forEach((btn) => {
        // hide howToPlay btn
        btn.style.display = "none"

        // but if user scroll 200px down, make them appear
        window.addEventListener('scroll', () => {
            if (window.scrollY >= 200) {
                howToPlayBtns.forEach((btn) => {
                    // check
                    if (btn !== howToPlayBtns[0]) {
                        btn.style.display = "block";
                    }
                });
                
            } else {
                howToPlayBtns.forEach((btn) => {
                    btn.style.display = "none"
                })
            }
        })

        btn.addEventListener('click', () => {
            howToPlay.classList.remove('hidden')
            overlay.classList.remove('hidden')

            // Positionner l'élément howToPlay au centre du viewport
            const viewportWidth = window.innerWidth
            const viewportHeight = window.innerHeight

            const howToPlayWidth = howToPlay.offsetWidth
            const howToPlayHeight = howToPlay.offsetHeight

            const topPosition = (viewportHeight - howToPlayHeight) / 2 + window.scrollY
            const leftPosition = (viewportWidth - howToPlayWidth) / 2

            howToPlay.style.top = `${topPosition}px`
            howToPlay.style.left = `${leftPosition}px`
        })
    })
    // ----------------------------------------------------------------------------------------

    // ----------------------------------------------------------------------------------------
    // --------- nextBtn/endBtns submission prevention ----------------------------------------
    // SHOW STEP 2 on nextBtn click IF user selected atleast 1 character and 1 boss
    randomizerForm.addEventListener('submit', (event) => {
        // get the amount of characters input checked
        var charactersCount = form.querySelectorAll('#characters .list label input:checked').length
        // get the amount of bosses input checked
        var bossesCount = form.querySelectorAll('#bosses .list label input:checked').length
    
        // if user selected less than 1 character or 1 boss, don't submit the form and show an alert
        if (charactersCount < 1 || bossesCount < 1) {
            event.preventDefault()
            alert('You have to select at least 1 character and 1 boss')
    
            // Redirect to the #characters section
            window.location.hash = ''
            window.location.hash = '#characters'
        }
    })


} else {
    console.log(1)
    nextBtn.addEventListener('click', (event) => {
        // get the amount of characters input checked
        var charactersCount = form.querySelectorAll('#characters .list label input:checked').length
        // get the amount of bosses input checked
        var bossesCount = form.querySelectorAll('#bosses .list label input:checked').length

        // if user selected less than 1 character, don't show step 2 and alert()
        if (charactersCount < 1 || bossesCount < 1) {
            event.preventDefault()
            alert('You have to select at least 1 character and 1 boss')
        } else {
            step1.classList.add('hidden')
            step2.style.display = "flex"
            endBtns.style.display = "unset"
        }
    })

    howToPlayBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            howToPlay.classList.remove('hidden')
            overlay.classList.remove('hidden')
        })
    })
}


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