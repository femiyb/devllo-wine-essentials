<?php
/**
 * Helper utilities for Devllo Wine Essentials.
 */

namespace Devllo\WineEssentials;

class Helpers {

    /**
     * Return boolean flag for a checkbox option.
     */
    public function is_enabled( $key, $default = 'yes' ) {
        $value = get_option( $key, $default );
        return 'yes' === $value || true === $value || 1 === (int) $value;
    }

    /**
     * Get raw option value.
     */
    public function get_option( $key, $default = '' ) {
        return get_option( $key, $default );
    }

    /**
     * Collect wine metadata for a product.
     */
    public function get_wine_meta( $product_id ) {
        $keys = array(
            'highlights'=> '_dwe_highlights',
            'wine_type' => '_dwe_wine_type',
            'vintage'   => '_dwe_vintage',
            'winery'    => '_dwe_winery',
            'region'    => '_dwe_region',
            'appellation' => '_dwe_appellation',
            'grape'     => '_dwe_grape',
            'badge'     => '_dwe_badge',
            'drinking_style' => '_dwe_drinking_style',
            'aroma'     => '_dwe_aroma',
            'body'      => '_dwe_body',
            'sweetness' => '_dwe_sweetness',
            'producer'  => '_dwe_producer',
            'abv'       => '_dwe_abv',
            'pairs_with'=> '_dwe_pairs_with',
        );

        $meta = array();
        foreach ( $keys as $label => $meta_key ) {
            $meta[ $label ] = get_post_meta( $product_id, $meta_key, true );
        }

        return $meta;
    }

    /**
     * Determine if a product has any wine metadata set.
     */
    public function has_wine_meta( $product_id ) {
        $meta = $this->get_wine_meta( $product_id );
        return ! empty( array_filter( $meta ) );
    }

    /**
     * Load a WooCommerce template with overrides.
     */
    public function get_template( $template_name, $args = array() ) {
        if ( ! function_exists( 'wc_get_template' ) ) {
            return;
        }

        wc_get_template(
            $template_name,
            $args,
            'devllo-wine-essentials/',
            DWE_PLUGIN_DIR . 'public/templates/'
        );
    }
}
