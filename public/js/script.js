// ---------------------------------------------------------------------------------------------------
// FLASH MSG DISAPPEARANCE ---------------------------------------------------------------------------
$(document).ready(function() {
    var i = 2000
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

// ---------------------------------------------------------------------------------------------------
// HREF REDIRECTION ON ELEMENTS ----------------------------------------------------------------------
var hrefElements = document.querySelectorAll('.href-element')

hrefElements.forEach(function (hrefElement) {
    hrefElement.addEventListener('click', function(event) {
        // get data-href attribute which is : <div class="href-element" data-href="example/route...">
        var url = this.getAttribute('data-href')
        window.location.href = url


        event.stopPropagation()
    })
})

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