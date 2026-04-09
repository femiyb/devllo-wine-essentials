document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dwe-add-to-compare').forEach(function(btn) {
        btn.addEventListener('click', function() {
            btn.classList.add('is-loading');
            btn.setAttribute('aria-disabled', 'true');
        });
    });
});