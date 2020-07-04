$(document).ready(function () {
    const debounce = function (fn, time) {
        let timeout;

        return function () {
            let self = this;
            const functionCall = function () {
                return fn.apply(self, arguments);
            };
            clearTimeout(timeout);
            timeout = setTimeout(functionCall, time);
        }
    };

    const calculateSum = function () {
        const $sumAll = $('.cart__value-sum');

        if ($sumAll.length > 0) {
            return $sumAll.toArray().reduce(function (sum, element) {
                if (isNaN(sum)) sum = 0;
                return sum + Number(element.textContent);
            }, 0);
        }

        return 0;

    };

    const calculate = function ($input) {
        const $parent = $input.parents('.cart__item-footer'),
            $price = $parent.find('.cart__value-price'),
            $sum = $parent.find('.cart__value-sum');

        $sum.text(+$input.val() * $price.text());

        changeTotals();
    };

    const changeTotals = function () {
        const $totalSum = $('#totalSum'),
            $totalSumHeader = $('#totalSumInfo'),
            $totalGoodsHeader = $('#totalGoodsInfo'),
            sum = calculateSum();
        $totalSum.text(sum);
        $totalSumHeader.text(sum);
        $totalGoodsHeader.text($('.cart__item').length);
    };


    $('.qty__minus').on('click', function (evt) {
        var $input = $(this).siblings('.qty__input');

        if ($input.val() > 0) {
            $input.val($input.val() - 1);
        }
        calculate($input);
        $input.trigger('change');
    });

    $('.qty__plus').on('click', function (evt) {
        var $input = $(this).siblings('.qty__input');

        $input.val(+$input.val() + 1);

        calculate($input);
        $input.trigger('change');
    });

    $('.qty__input').on('change', debounce(function (e) {
        const url = $('#cartList').data('url');
        $.ajax({
            _csrf: yii.getCsrfToken(),
            url: url,
            method: 'post',
            data: {
                'CartForm[goodId]': $(this).parents('.cart__item').data('good-id'),
                'CartForm[qty]': $(this).val(),
            },
            success: function () {

            }
        })

    }, 300));

    $('.cart__item-trash').on('click', function () {
        if (confirm('Вы действительно хотите удалить эту позицию из корзины?')) {
            const $goodId = $(this).data('good-id');
            $(this).parents('.cart__item').remove();

            changeTotals();

            const url = $(this).data('delete-url');

            $.ajax({
                _csrf: yii.getCsrfToken(),
                url: url,
                method: 'post',
                success: function () {

                }
            })
        }
    });

});