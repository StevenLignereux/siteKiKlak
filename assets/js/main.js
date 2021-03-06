
const aos = require("aos");
import Masonry from 'masonry-layout';

const responsive = {
    0: {
        items: 1
    },
    320: {
        items: 1
    },
    560: {
        items: 2
    },
    960: {
        items: 3
    }
}

aos.init();


$(document).ready(() => {
// ------------------------------------Responviv Script-------------------------------------------------------------------
    let $nav = $('.nav');
    let $toggleCollapse = $('.toggle-collapse');

    /** click event on toggle menu */
    $toggleCollapse.click(() => {
        $nav.toggleClass('collapse');

    })
// -----X-----------------------------Responviv Script----------------------------------X--------------------------------
// --------------------------------------Modal box-------------------------------------------------------------------------
    let modal = null;

    const openModal = function (e) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        target.style.display = null;
        target.removeAttribute('aria-hidden');
        target.setAttribute('aria-modal', 'true');
        modal = target;
        modal.addEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
    }

    const closeModal = function (e) {
        if (modal === null) return
        e.preventDefault();
        modal.style.display = "none";
        modal.setAttribute('aria-hidden', true);
        modal.removeAttribute('aria-modal');
        modal.removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
        modal = null;
    }

    const stopPropagation = function (e) {
        e.stopPropagation();
    }

    document.querySelectorAll('.js-modal').forEach(a => {
        a.addEventListener('click', openModal);

    });

    // ----------------X----------------------Modal box--------------------------------------X-----------------------------------

    // ----------------------------------------- Carousel----------------------------------------------------------------------------
    $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay: false,
        autoplayTimeout: 3000,
        dots: false,
        nav: true,
        navText: [$('.owl-navigation .owl-nav-prev'), $('.owl-navigation .owl-nav-next')],
        responsive: responsive
    });

    // ------------------X----------------------- Carousel------------------------------------X----------------------------------------
    // ---------------------------------------------- Click to scroll up -----------------------------------------------------------------
    $('.move-up span').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
    });
    // ------------------X---------------------------- Click to scroll up ----------------------X-------------------------------------------

    // ---------------------------------------------- Masonry Gallery -----------------------------------------------------------------
    const grid = document.querySelector('.grid');

    new Masonry(grid, {
       itemSelector: '.grid-item',
        gutter: 15
    });

    // ------------------X---------------------------- Masonry Gallery -------------------------X---------------------------------------
});



