const form = document.querySelector('form:first-of-type')
const discordChannelInput = document.querySelector('#registration_form_password_first')

form.addEventListener('submit', (event) => {

    const regex = /^(http(s):\/\/.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/g

    if (!regex.test(discordChannelInput.value)) {
        event.preventDefault()
        alert("Your discord link is not a valid link.")
    }

})

