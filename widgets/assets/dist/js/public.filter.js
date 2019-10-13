(function ($) {
    $filterForm = $('#filter-aside');

    $filterForm.on('click', function (evt) {
        $target = $(evt.target);

        if ($target.is('input')) {

            $.ajax({

                data: $filterForm.serialize(),
                success: function (data) {
                    if (data) {
                        var $itemsWrapper = $('.dynamic-pager-items');
                        $itemsWrapper.html(data.items);
                        $('.dynamic-paginator').html(data.paginator);
                    }
                }
            })
        }

    })
})($);