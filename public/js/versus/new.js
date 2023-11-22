document.addEventListener('DOMContentLoaded', function () {
    // -----------------------------------------------------------------------------------------------------------------------
    // ------------- Prevent form submit if startDate or endDate are incorrect -----------------------------------------------
    const form = document.querySelector('form')

    form.addEventListener('submit', function(event) {
      // Récupérer les champs de date de début et de fin
      const startDateInput = document.querySelector('#versus_startDate')
      const startDate = new Date(startDateInput.value)

      const endDateInput = document.querySelector('#versus_endDate')
      const endDate = new Date(endDateInput.value)


      // get today's date
      const now = new Date()

      // if start date is prior to today's date
      if (startDate < now) {
          // prevent form submitting
          event.preventDefault()
          // alert
          alert('Start date can\'t be prior to today\'s date')
          return
      }

      // if end date is prior to today's date
      if (endDate < now) {
          // prevent form submitting
          event.preventDefault()
          // alert
          alert('End date can\'t be prior to today\'s date')
          return
      }

    })
    // -----------------------------------------------------------------------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------------------
})