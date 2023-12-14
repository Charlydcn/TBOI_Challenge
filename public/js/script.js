// ---------------------------------------------------------------------------------------------------
// FLASH MSG DISAPPEARANCE ---------------------------------------------------------------------------
$(document).ready(function() {
    var i = 5000

    $(this).delay(1000)

    $(".flash").each(function() {
        if ($(this).text().length > 0) {
            $(this).slideDown(500, function() {
                $(this).delay(i).slideUp(500)
            })

            i += 625
        }
    })

    $(".flash").on('click', function() {
        $(this).remove()
    })
})

// make header appear/disappear on scroll
if ($(window).width() <= 991) {
    var previousScroll = 0
    var header = $('header')

    $(window).on('scroll', function() {
        if ($(window).width() <= 991) {
            var currentScroll = $(this).scrollTop()

            if (currentScroll > previousScroll && currentScroll > 100) {
                header.css('transform', 'translateY(-10rem)')
            } else {
                header.css('transform', 'unset')
            }

            previousScroll = currentScroll
        }
    })
}






// ---------------------------------------------------------------------------------------------------
// HREF REDIRECTION ON ELEMENTS ----------------------------------------------------------------------
var hrefElements = document.querySelectorAll('.href-element');

hrefElements.forEach(function (hrefElement) {
    hrefElement.addEventListener('click', function(event) {
        var url = this.getAttribute('data-href');
        var target = this.getAttribute('data-target');

        if (target && target === '_blank') {
            window.open(url, '_blank');
        } else {
            window.location.href = url;
        }

        event.stopPropagation();
    });
});


// ---------------------------------------------------------------------------------------------------
// INFOS BOX ON CLICK --------------------------------------------------------------------------------
var onclickInfosElements = $('.onclick-infos-element')
var onclickInfos = $('.onclick-infos')

// on infosElement click
onclickInfosElements.on('click', function() {
    // add 'hidden' class to all onclickInfos except clicked infosElement
    onclickInfos.not($(this).next()).addClass('hidden')

    $(this).next().toggleClass('hidden')
})

$(document).on('click', function(event) {
    // is the click isn't on a onclickInfos element nor a onclickInfosElement
    if (!$(event.target).is(onclickInfos) && !$(event.target).is(onclickInfosElements)) {
        // hide all onclickInfos elements
        $('.onclick-infos').addClass('hidden')
    }
})

// ---------------------------------------------------------------------------------------
// ------------- start a game (isaac's appId : 250900) -----------------------------------
function launchSteamGame(appId) {
    var steamLink = "steam://run/" + appId

    window.open(steamLink)
}

// -------------------------------------------------------------------------

// -------------------------------------------------------------------------
// ----------- open responsive menu on click burger menu icon --------------
var responsiveMenu = $('#responsive-menu')

$('nav #responsive img:last-of-type').on('click', function(event) {
    responsiveMenu.addClass('active')
    $('.overlay').css('display', 'unset')
    $('.overlay').css('z-index', '3')

    event.stopPropagation()
})

$(document).on('click', function(event) {
    if (!responsiveMenu.is(event.target) && responsiveMenu.has(event.target).length === 0) {
        $(responsiveMenu).removeClass('active')
        $('.overlay').css('display', 'none')
        $('.overlay').css('z-index', '-1')
    }
})

$('#close-btn').on('click', function(event) {
    $(responsiveMenu).removeClass('active')
        $('.overlay').css('display', 'none')
        $('.overlay').css('z-index', '-1')
})

// -------------------------------------------------------------------------
// -------------------------------------------------------------------------

// -------------------------------------------------------------------------
// ----------- confirmation delete btns ------------------------------------
$(".delete-btn").on("click", function() {
    return confirm("Are you sure you want to delete this ?")
})

// -----------------------------------------------------------------------------------------
// ----- prevent start date to be prior to today's date ------------------------------------

var today = new Date().toISOString().slice(0, new Date().toISOString().lastIndexOf(":"));
var dateInputs = document.querySelectorAll('.date-input');

dateInputs.forEach(function(dateInput) {
    dateInput.setAttribute('min', today)
});




// -----------------------------------------------------------------------------------------