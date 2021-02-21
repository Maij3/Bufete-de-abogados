(function ($) {
    $(document).ready(function () {
        // -------------------------
        // Init
        // -------------------------
        if (!$('.mod-page-heading')) return;

        var pageHeading = $('.page-heading');
        var subHeading = $('.mod-page-heading span.sub-heading');

        // Move page heading before sub-heading
        subHeading.before(pageHeading);

    });
})(jQuery);