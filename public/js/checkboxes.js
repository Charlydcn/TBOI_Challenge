// every click on '.check-btn' (css selector)
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

// checkall buttons
$('.prevent-select[data-action="checkall"]').click(function(event) {
                    // checkall > '.btns' > '.list' > '.checkbox'
    var checkboxes = $(this).parent().next().find('.checkbox')

    $.each(checkboxes, function(value) {
        // find div containing label img and text
        var checkBtnDiv = $(this).next()

        $(this).prop('checked', true)

        // add class 'checked' to label text and img
        checkBtnDiv.addClass('checked')
        checkBtnDiv.find('img').addClass('checked')
    })

    // preventDefault to not trigger function twice (<a> tag so it triggers twice)
    event.preventDefault();
});

// checknone buttons
$('.prevent-select[data-action="checknone"]').click(function(event) {
                    // checkall > '.btns' > '.list' > '.checkbox'
    var checkboxes = $(this).parent().next().find('.checkbox')

    $.each(checkboxes, function(value) {
        // find div containing label img and text
        var checkBtnDiv = $(this).next()

        $(this).prop('checked', false)

        // add class 'checked' to label text and img
        checkBtnDiv.removeClass('checked')
        checkBtnDiv.find('img').removeClass('checked')
    })

    // preventDefault to not trigger function twice (<a> tag so it triggers twice)
    event.preventDefault();
});


