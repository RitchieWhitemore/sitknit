$(document).ready(function () {
    $('.qty__minus').on('click', function (evt) {
        var $input = $(this).siblings('.qty__input');

        if ($input.val() > 0) {
            $input.val($input.val() - 1);
        }

    });

    $('.qty__plus').on('click', function (evt) {
        var $input = $(this).siblings('.qty__input');

        $input.val(+$input.val() + 1);
    })
});