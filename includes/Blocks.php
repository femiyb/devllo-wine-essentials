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
            'dwe-wine-compare-block-editor',
            DWE_PLUGIN_URL . 'blocks/wine-compare/editor.js',
            array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
            DWE_VERSION,
            true
        );

        register_block_type(
            DWE_PLUGIN_DIR . 'blocks/wine-compare',
            array(
                'render_callback' => array( $this, 'render_compare_block' ),
                'editor_script'   => 'dwe-wine-compare-block-editor',
            )
        );

        wp_register_script(
            'dwe-wine-profile-block-editor',
            DWE_PLUGIN_URL . 'blocks/wine-profile/editor.js',
            array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
            DWE_VERSION,
            true
        );

        register_block_type(
            DWE_PLUGIN_DIR . 'blocks/wine-profile',
            array(
                'render_callback' => array( $this, 'render_profile_block' ),
                'editor_script'   => 'dwe-wine-profile-block-editor',
            )
        );
    }

    /**
     * Render callback for compare block.
     */
    public function render_compare_block( $attributes, $content ) {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_compare' ) ) {
            return '';
        }

        return do_shortcode( '[dwe_compare]' );
    }

    /**
     * Render callback for wine profile block.
     */
    public function render_profile_block() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_profile' ) ) {
            return '';
        }

        global $product;
        if ( ! $product || ! $product instanceof \WC_Product ) {
            $product = wc_get_product( get_the_ID() );
        }

        if ( ! $product instanceof \WC_Product ) {
            return '';
        }

        $meta = $this->helpers->get_wine_meta( $product->get_id() );
        if ( empty( array_filter( $meta ) ) ) {
            return '';
        }

        $field_keys = array( 'highlights', 'wine_type', 'vintage', 'region', 'grape', 'body', 'sweetness', 'aroma', 'winery', 'appellation', 'producer', 'drinking_style', 'abv', 'pairs_with' );
        $allowed    = array();
        foreach ( $field_keys as $key ) {
            if ( $this->helpers->is_enabled( 'dwe_show_' . $key ) ) {
                $allowed[] = $key;
            }
        }

        ob_start();
        $this->helpers->get_template(
            'wine-profile.php',
            array(
                'product'        => $product,
                'meta'           => $meta,
                'allowed_fields' => $allowed,
            )
        );
        return ob_get_clean();
    }
}
