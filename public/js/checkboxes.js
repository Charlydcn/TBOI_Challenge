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
                    // checkall > '.btns' > '.list' > '.checkbox'
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
                    // checkall > '.btns' > '.list' > '.checkbox'
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

var restrChanceLabel = $('#step2 .list label:first-of-type')
var restrChanceCheckboxes = $('#step2 .list input[type="checkbox"]')

restrChanceCheckboxes.on('change', function () {
    // check if one of the restrChanceCheckboxes is checked
    var oneChecked = restrChanceCheckboxes.is(':checked')
    
    if (oneChecked) {
        restrChanceLabel.css("max-height", "150px")
    } else {
        restrChanceLabel.css("max-height", "0")
    }
})

// --------------------------------------------------------------------------------------
