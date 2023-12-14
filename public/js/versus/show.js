document.addEventListener('DOMContentLoaded', function() {

    // -----------------------------------------------------------------------------------------
    // ----- countdown -------------------------------------------------------------------------
    const startDateString = document.querySelector('.start-date').getAttribute('data-date')
    const startDate = new Date(startDateString).getTime()

    // mettre à jour le compteur chaque seconde (1s = 1000 ms)
    const countdownInterval = setInterval(updateCountdown, 1000)

    function updateCountdown() {
            // date + heure courante
        const currentDate = new Date().getTime()
        // calculer la différence entre la date de Noël et la date courante
        const timeDifference = startDate - currentDate

        // si on a passé la date, on affiche 0 pour toutes les valeurs (jours, heures, minutes, secondes)
        if (timeDifference <= 0) {
            clearInterval(countdownInterval)
            displayCountdown(0, 0, 0, 0)
        } else {
            // on calcule le nombre de jours, heures, minutes, secondes qu'il reste
            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24))
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60))
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000)

            // on affiche le résultat
            displayCountdown(days, hours, minutes, seconds)
        }
    }

    function displayCountdown(days, hours, minutes, seconds) {
        document.getElementById('days').innerText = days
        document.getElementById('hours').innerText = hours
        document.getElementById('minutes').innerText = minutes
        document.getElementById('seconds').innerText = seconds
    }

    updateCountdown()
    // -----------------------------------------------------------------------------------------
})
