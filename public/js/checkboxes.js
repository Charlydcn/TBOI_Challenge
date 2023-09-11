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

/* characters 'check all' button */
$('.checkall-ch').click(function(event) {
    var checkboxes = $('.checkbox-ch');

    checkboxes.each(function() {
        var checkBtnDiv = $(this).closest('label').find('.check-btn');
        
        if (!$(this).prop('checked')) {
            // check the checkbox
            $(this).prop('checked', true);

            // add class to elements
            checkBtnDiv.addClass('checked');
            checkBtnDiv.find('img').addClass('checked');
        }
    });

    // preventDefault() to not trigger the default click eventListener (if no preventDefault, click triggers function twice)
    event.preventDefault();
});

/* characters 'check none' button */
$('.none-ch').click(function(event) {
    var checkboxes = $('.checkbox-ch');

    checkboxes.each(function() {
        var checkBtnDiv = $(this).closest('label').find('.check-btn');

        if ($(this).prop('checked')) {
            // Décochez la case à cocher
            $(this).prop('checked', false);

            // Supprimez la classe "checked" de la div et de l'image
            checkBtnDiv.removeClass('checked');
            checkBtnDiv.find('img').removeClass('checked');
        }
    });

    // preventDefault() to not trigger the default click eventListener (if no preventDefault, click triggers function twice)
    event.preventDefault();
});

/* bosses 'check all' button */
$('.checkall-boss').click(function(event) {
    var checkboxes = $('.checkbox-boss');

    checkboxes.each(function() {
        var checkBtnDiv = $(this).closest('label').find('.check-btn');
        
        if (!$(this).prop('checked')) {
            $(this).prop('checked', true);

            checkBtnDiv.addClass('checked');
            checkBtnDiv.find('img').addClass('checked');
        }
    });

    // Empêchez le comportement par défaut du clic
    event.preventDefault();
});

/* bosses 'check none' button */
$('.none-boss').click(function(event) {
    var checkboxes = $('.checkbox-boss');

    checkboxes.each(function() {
        var checkBtnDiv = $(this).closest('label').find('.check-btn');

        if ($(this).prop('checked')) {
            $(this).prop('checked', false);

            checkBtnDiv.removeClass('checked');
            checkBtnDiv.find('img').removeClass('checked');
        }
    });

    event.preventDefault();
});

