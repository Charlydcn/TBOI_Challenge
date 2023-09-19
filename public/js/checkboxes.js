// --------------------------------------------------------------------------------------
// check checkbox on click on '.check-btn' ----------------------------------------------
$('.check-btn').click(function(event) {
    // checkbox = closest 'input' element from $(this), which is the '.check-btn' that has been clicked
    var checkbox = $(this).closest('input')
    
    /* we store the contrary of the property (prop.) 'checked' of the checkbox (bool) to apply it (declare true if it was false and vice versa) */
    var check = !$(checkbox).prop('checked')
    // 'prop.' = properties: 'prop.property, value'
    checkbox.prop('checked', check)

    // toggleClass = if it had it already it removes it, and vice versa
    $(this).toggleClass('checked')
    // same here, find('') = css selector from $(this), so the '.check-btn' that got clicked on
    $(this).find('img').toggleClass('checked')
})
// --------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------
// check all checkboxes on checkall btns ------------------------------------------------
$('.prevent-select[data-action="checkall"]').click(function(event) {
                    // checkall > '.btns' > '.list' > input checkbox of class '.checkbox'
    var checkboxes = $(this).parent().next().find('.checkbox')

    $.each(checkboxes, function() {
        // find div containing label img and text
        var checkBtnDiv = $(this).next()

        $(this).prop('checked', true)
        $(this).trigger('change')

        // add class 'checked' to label text and img
        checkBtnDiv.addClass('checked')
        checkBtnDiv.find('img').addClass('checked')

    })
    
    // preventDefault to not trigger function twice (<a> tag so it triggers twice)
    event.preventDefault()
})
// --------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------
// check none checkboxes on checknone btns ----------------------------------------------

$('.prevent-select[data-action="checknone"]').click(function(event) {
                    // checkall > '.btns' > '.list' > input checkbox of class '.checkbox'
    var checkboxes = $(this).parent().next().find('.checkbox')

    $.each(checkboxes, function() {
        // find div containing label img and text
        var checkBtnDiv = $(this).next()

        $(this).prop('checked', false)
        $(this).trigger('change')

        // add class 'checked' to label text and img
        checkBtnDiv.removeClass('checked')
        checkBtnDiv.find('img').removeClass('checked')
    })

    // preventDefault to not trigger function twice (<a> tag so it triggers twice)
    event.preventDefault()
})
// --------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------
// display restrictions chance if atleast one checkbox is checked -----------------------

var restrChanceLabel = $('#step2 #restr-chance')
var restrictionsCheckbox = $('#step2 .checkbox')

restrictionsCheckbox.on('change', function() {
    // check if one of the restrictionsCheckbox is checked
    var oneChecked = restrictionsCheckbox.is(':checked')
    
    if (oneChecked) {
        restrChanceLabel.css("max-height", "150px")
    } else {
        restrChanceLabel.css("max-height", "0")
    }
})

// --------------------------------------------------------------------------------------


// --------------------------------------------------------------------------------------
// show win-streak input number if win-streak checkbox is checked -----------------------

var streakCheckbox = $('#streak label:first-of-type input')
var streakInputNb = $('#streak label:last-of-type')

streakCheckbox.on('change', function() {
    if ((streakCheckbox.prop('checked')) === true) {
        streakInputNb.css("opacity", "100")
        streakInputNb.css("translate", "0")
    } else {
        streakInputNb.css("opacity", "0")
        streakInputNb.css("translate", "-45px")
    }
})

// --------------------------------------------------------------------------------------
