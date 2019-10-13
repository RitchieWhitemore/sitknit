window.loadMore = function (el) {
    var $this = $(el),
        url = $this.data('url');
    if ($this.data('loading') === true) {
        return $.Deferred().reject('Loading now');
    }
    if (url <= '') {
        return $.Deferred().reject('No data-url property defined');
    }
    var $paginator = $('.' + $this.data('class')),
        $container = $('.' + $this.data('items'));
    if (!$paginator.length || !$container.length) {
        return $.Deferred().reject('No containers found for loading');
    }
    $this.data('loading', true);
    $container.css('opacity', 0.3);

    return $.ajax({
        url: url,
        dataType: 'JSON',
        data: {ajax: 1},
        type: 'get',
        complete: function () {
            $this.data('loading', false);
        },
        success: function (data) {
            $this.data('loading', false);
            if (data.result === 'OK') {
                var count = $('.' + $this.data('count'));
                var current = count.find('.current');
                var sum = count.find('.sum');
                $paginator.html(data.paginator);
                $container.append(data.items);
                $container.css('opacity', 1);
                sum.text(data.total);
                current.text(parseInt(current.text()) + parseInt(data.count));
                if (!!(window.history && window.history.pushState)) {
                    history.pushState({}, document.title, url);
                }
                var scrollTop = $container.offset().top - 100;
                // $('html, body').animate({scrollTop: scrollTop}, 500);

                $(window).trigger('render.image.bg');
            }
        }
    });
};
