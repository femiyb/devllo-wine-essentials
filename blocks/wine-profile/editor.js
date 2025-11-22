( function ( blocks, element ) {
    var el = element.createElement;
    var __ = wp.i18n.__;

    blocks.registerBlockType( 'devllo/wine-profile', {
        edit: function () {
            return el('div', { className: 'dwe-block-preview' }, __('Wine Profile will render on the frontend.', 'devllo-wine-essentials'));
        },
        save: function () {
            return null; // Rendered server-side
        }
    });
})( window.wp.blocks, window.wp.element );
