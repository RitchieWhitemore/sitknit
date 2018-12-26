var FILE_TYPES = ['gif', 'jpg', 'jpeg', 'png'];
var imagesList = document.querySelector('#images-list');
var inputAddImage = document.querySelector('#input-add-image');
var imageItemTemplate = document.querySelector('#images-item-template');

inputAddImage.addEventListener('change', function () {
    var file = inputAddImage.files[0];
    var fileName = file.name.toLowerCase();

    var matches = FILE_TYPES.some(function (it) {
        return fileName.endsWith(it);
    });

    if (matches) {
        var reader = new FileReader();
        reader.addEventListener('load', function () {
            var li = document.createElement('li');
            li.classList.add('images__item');
            var imageElement = document.createElement('img');
            imageElement.src = reader.result;
            li.appendChild(imageElement);

            imagesList.appendChild(li);
        });

        reader.readAsDataURL(file);
    }
});