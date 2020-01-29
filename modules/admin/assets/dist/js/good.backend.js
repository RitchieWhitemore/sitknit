$(document).ready(function () {
    var $percentInput = $('#percentInput'),
        $currentPercent = $('#currentPercent'),
        $retailPrice = $('#retailPrice'),
        $wholesalePrice = $('#wholesalePrice');

    $percentInput.on('input keyup', function (e) {
        var newRetailPrice = +$wholesalePrice.text() * $percentInput.val() / 100;
        if ($currentPercent.text !== $percentInput.val()) {
            $retailPrice.text(newRetailPrice);
        }
    })
});