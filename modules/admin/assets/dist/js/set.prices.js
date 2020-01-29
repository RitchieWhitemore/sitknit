(function ($) {
    var $gridView = $('#remaining-table');

    $gridView.on('click', function (e) {
        var target = e.target;
        target = $(target);

        if (target.data('name') === 'set-price-button') {
            uploadPrice(target);
        }
    });

    $gridView.on('keypress', function (e) {

        if (e.keyCode === 13) {
            var target = e.target;
            target = $(target);
            uploadPrice(target.next());
        }
    });

    var uploadPrice = function (target) {

        var formData = {
            'PriceForm[type_price]': target.data('type'),
            'PriceForm[good_id]': target.data('id'),
            'PriceForm[date]': $('#date-price').val(),
            'PriceForm[price]': target.prev().val(),
        };

        $.ajax({
            url: $gridView.data('url'),
            type: 'POST',
            data: formData,
            success: function (data) {
                alert(data);
                updateDifference(target);
            },
            error: function (data) {
                console.log(data);
            }
        });
    };

    var updateDifference = function (target) {
        var id = target.data('id');

        var wholesale = $('#wholesale-price-' + id).val();
        var retail = $('#retail-price-' + id).val();

        var calculate = '-';

        if (wholesale && retail) {
            calculate = (retail - wholesale) / wholesale * 100;
            calculate = Math.round(calculate) + '%';
        }

        $('#difference-' + id).text(calculate);
    };

    $('input[name=wholesale], input[name=retail]').on('input keyup', function (e) {
        var $target = $(e.target);

        updateDifference($target);
    });
})(jQuery);