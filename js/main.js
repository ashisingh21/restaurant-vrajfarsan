$(document).ready(function () {
    //   setTimeout(function() {
    //   $('.home .popup-bg,.menu-page .popup-bg').show()
    // }, 2000);
    $('.close-popup').click(function () {
        $('.popup-bg').hide()
    })


    $('a.icon').click(function (e) {
        $(this).css({
            'display': 'block',
            'padding-top': '30px'
        })

    });
});