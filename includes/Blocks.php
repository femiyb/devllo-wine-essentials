<?php
/**
 * Gutenberg blocks for Devllo Wine Essentials.
 */

namespace Devllo\WineEssentials;

class Blocks {

    /**
     * @var Helpers
     */
    protected $helpers;

    /**
     * Constructor.
     */
    public function __construct( Helpers $helpers ) {
        $this->helpers = $helpers;
    }

    /**
     * Register blocks on init.
     */
    public function register_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        wp_register_script(
            'devllowine-wine-compare-block-editor',
            DEVLLOWINE_PLUGIN_URL . 'blocks/wine-compare/editor.js',
            array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
            DEVLLOWINE_VERSION,
            true
        );

        register_block_type(
            DEVLLOWINE_PLUGIN_DIR . 'blocks/wine-compare',
            array(
                'render_callback' => array( $this, 'render_compare_block' ),
                'editor_script'   => 'devllowine-wine-compare-block-editor',
            )
        );
    }

    /**
     * Render callback for compare block.
     */
    public function render_compare_block( $attributes, $content ) {
        if ( ! $this->helpers->is_enabled( 'devllowine_enable_compare' ) ) {
            return '';
        }

        return do_shortcode( '[devllowine_compare]' );
    }
}
