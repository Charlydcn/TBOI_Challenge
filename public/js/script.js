// Flash messages disappearance
$(document).ready(function() {
    var i = 1500
    $(this).delay(1000)
    $(".flash").each(function() {
        if ($(this).text().length > 0) {
            $(this).slideDown(500, function() {
                $(this).delay(i).slideUp(500)
                i += 625
            })
        }
    })
})