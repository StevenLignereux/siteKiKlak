$(document).ready(() => {
    let $nav = $('.nav');
    let $toggleCollapse = $('.toggle-collapse');

    /** click event on toggle menu */
    $toggleCollapse.click (() => {
        $nav.toggleClass('collapse');
    })
})