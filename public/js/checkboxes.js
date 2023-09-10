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
            // Cochez la case à cocher
            $(this).prop('checked', true);

            // Ajoutez la classe "checked" à la div et à l'image
            checkBtnDiv.addClass('checked');
            checkBtnDiv.find('img').addClass('checked');
        }
    });

    // Empêchez le comportement par défaut du clic
    event.preventDefault();
});

/* Désélectionner toutes les cases à cocher */
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

    // Empêchez le comportement par défaut du clic
    event.preventDefault();
});

