
var navMain = document.querySelector('.main-nav');
var navToggle = document.querySelector('.main-nav__toggle');
var navSubMenuItem = document.querySelector('.main-nav__item--dropdown > .main-nav__link');
var navSubMenuList = document.querySelector('.main-nav__list-sub');

var filterButton = document.querySelector('.filter__button');
var filterForm = document.querySelector('.filter');

navMain.classList.remove('main-nav--nojs');

navToggle.addEventListener('click', function () {
    if (navMain.classList.contains('main-nav--closed')) {
        navMain.classList.remove('main-nav--closed');
        navMain.classList.add('main-nav--opened');
    } else {
        navMain.classList.remove('main-nav--opened');
        navMain.classList.add('main-nav--closed');
    }
});

/*navSubMenuItem.addEventListener('click', function () {
    event.preventDefault();
    if (navSubMenuList.classList.contains('main-nav__list-sub--closed')) {
        navSubMenuList.classList.remove('main-nav__list-sub--closed');
        navSubMenuList.classList.add('main-nav__list-sub--opened');
    } else {
        navSubMenuList.classList.remove('main-nav__list-sub--opened');
        navSubMenuList.classList.add('main-nav__list-sub--closed');
    }
});*/

filterButton.addEventListener('click', function () {
    if (filterButton.classList.contains('filter__button--closed')) {
        filterButton.classList.remove('filter__button--closed');
        filterButton.classList.add('filter__button--opened');
        filterForm.classList.remove('filter--closed');
        filterForm.classList.add('filter--opened');
    } else {
        filterButton.classList.remove('filter__button--opened');
        filterButton.classList.add('filter__button--closed');
        filterForm.classList.remove('filter--opened');
        filterForm.classList.add('filter--closed');
    }
});
