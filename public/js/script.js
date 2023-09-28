// Flash messages disappearance
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

// href redirection on elements
var hrefElements = document.querySelectorAll('.href-element');

hrefElements.forEach(function (hrefElement) {
    hrefElement.addEventListener('click', function(event) {
        // get data-href attribute which is : <div class="href-element" data-href="example/route...">
        var url = this.getAttribute('data-href');
        window.location.href = url;


        event.stopPropagation();
    });
});