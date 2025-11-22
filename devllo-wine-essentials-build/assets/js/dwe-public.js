(function ($) {
    $(document).on('click', '.dwe-add-compare', function () {
        var $btn = $(this);
        if ($btn.hasClass('is-loading')) {
            return;
        }
        $btn.addClass('is-loading');
        $btn.data('original-text', $btn.text());
        $btn.text($btn.hasClass('added') ? $btn.text() : $btn.text());
        $btn.text('Adding...');
    });

    $(document).ready(function () {
        $('.dwe-wine-profile, .dwe-wine-recommendations').css({ opacity: 0, transform: 'translateY(8px)' });
        setTimeout(function () {
            $('.dwe-wine-profile, .dwe-wine-recommendations').css({ transition: 'all 200ms ease', opacity: 1, transform: 'none' });
        }, 50);
    });
})(jQuery);
