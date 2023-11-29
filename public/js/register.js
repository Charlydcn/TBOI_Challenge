const form = document.querySelector('form:last-of-type')
const passwordInput = document.querySelector('#registration_form_password_first')

form.addEventListener('submit', (event) => {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{12,}$/

    if (!regex.test(passwordInput.value)) {
        event.preventDefault()
        alert("Your password must contain at least one lowercase letter, one uppercase letter, one digit, one special character, and be at least 12 characters long.")
    }
})
