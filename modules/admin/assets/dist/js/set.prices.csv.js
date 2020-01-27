(function ($) {
    var $buttonSubmit = $('#buttonSubmit');
    var $percent = $('#setpriceajaxform-percent_change');
    var $inputFile = $('#setpriceajaxform-file_input_price');
    var $spinner = $('#spinner');
    var $form = $('#w0');
    var $messages = $('#messages');
    var csv;
    var formData = new FormData($form[0]);
    var sessionStep = $form.data('session-step');

    $inputFile.on('change', function () {
        var fileInput = $inputFile[0].files[0];
        var reader = new FileReader();

        reader.addEventListener('load', function (e) {
            var parserExcel = document.querySelector('parser-excel');
            var result = e.target.result;
            Papa.parse(result, {
                delimiter: ';',
                complete: function (results) {
                    csv = results;
                }
            });
        });
        reader.readAsText(fileInput, 'CP1251');
    });


    var buildingString = function () {
        var $form = $('#w0');
        var sessionStep = $form.data('session-step');
        const endStep = +sessionStep + 1000;

        var pack = [];
        var data = csv.data;
        var arrayToString;

        for (var i = sessionStep; i < endStep; i++) {
            if (i == 0) continue;
            if (data.length > sessionStep) {
                if (data[i] != undefined && data[i].length > 1) {
                    arrayToString = data[i].join('|');
                    pack.push(arrayToString);
                }

            }
        }

        formData.append('SetPriceAjaxForm[stringPackCsv]', pack.join(';'));
        formData.append('SetPriceAjaxForm[beginStep]', sessionStep);

        $.ajax({
            url: '/api/price/set-price',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.count != 'Прайс загружен') {
                    sessionStep = +data.count;
                    buildingString();
                    $messages.append('<p>Загружено ' + data.count + ' записей</p>');
                } else {
                    $messages.append('<p>' + data.count + '</p>');
                    $spinner.hide();
                }
            }
        });
    };

    $buttonSubmit.on('click', function (e) {
        e.preventDefault();
        var $form = $('#w0');
        var sessionStep = $form.data('session-step');

        if ($percent.val() == '') {
            alert('Установите процент наценки');
            return;
        }

        if ($inputFile.val() == '') {
            alert('Выберите прайс-лист');
            return;
        }

        var fileInput = $inputFile[0].files[0];

        $spinner.show();

        buildingString();

        $messages.append('<p>Загрузка началась c ' + sessionStep + ' элемента</p>');
    })


})(jQuery);