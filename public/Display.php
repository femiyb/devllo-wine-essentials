<?php
/**
 * Frontend rendering for wine profile and recommendations.
 */

namespace Devllo\WineEssentials\Frontend;

use Devllo\WineEssentials\Helpers;
use Devllo\WineEssentials\Recommendations;
use WC_Product;

class Display {

    /**
     * @var Helpers
     */
    protected $helpers;

    /**
     * @var Recommendations
     */
    protected $recommendations;

    public function __construct( Helpers $helpers, Recommendations $recommendations ) {
        $this->helpers         = $helpers;
        $this->recommendations = $recommendations;
    }

    /**
     * Output badge for archive items.
     */
    public function display_badge_archive() {
        global $product;
        if ( ! $product instanceof WC_Product ) {
            return;
        }
        $this->render_badge( $product, 'archive' );
    }

    /**
     * Output badge for single product.
     */
    public function display_badge_single() {
        global $product;
        if ( ! $product instanceof WC_Product ) {
            return;
        }
        $this->render_badge( $product, 'single' );
    }

    /**
     * Render badge markup.
     */
    protected function render_badge( WC_Product $product, $context = 'archive' ) {
        if ( ! $this->helpers->is_enabled( 'dwe_show_badge' ) ) {
            return;
        }
        $badge = get_post_meta( $product->get_id(), '_dwe_badge', true );
        if ( empty( $badge ) ) {
            return;
        }
        $class = 'archive' === $context ? 'dwe-badge-overlay' : 'dwe-badge-overlay dwe-badge-single';
        echo '<div class="' . esc_attr( $class ) . '"><span class="dwe-wine-badge">' . esc_html( $badge ) . '</span></div>';
    }

    /**
     * Output wine profile block on product page.
     */
    public function display_wine_profile() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_profile' ) ) {
            return;
        }

        global $product;

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $meta = $this->helpers->get_wine_meta( $product->get_id() );

        if ( empty( array_filter( $meta ) ) ) {
            return;
        }

        $allowed_fields = array();
        $field_keys     = array( 'highlights', 'wine_type', 'vintage', 'region', 'grape', 'body', 'sweetness', 'aroma', 'winery', 'appellation', 'producer', 'drinking_style', 'abv', 'pairs_with' );
        foreach ( $field_keys as $key ) {
            if ( $this->helpers->is_enabled( 'dwe_show_' . $key ) ) {
                $allowed_fields[] = $key;
            }
        }

        $this->helpers->get_template(
            'wine-profile.php',
            array(
                'product'        => $product,
                'meta'           => $meta,
                'allowed_fields' => $allowed_fields,
            )
        );
    }

    /**
     * Output similar wines beneath product summary.
     */
    public function display_similar_wines() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_similar' ) ) {
            return;
        }

        global $product;

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $count = (int) $this->helpers->get_option( 'dwe_similar_count', 2 );
        $count = max( 1, min( 3, $count ) );
        $sort  = $this->helpers->get_option( 'dwe_similar_sort', 'rand' );
        $sort  = in_array( $sort, array( 'rand', 'price', 'price-desc' ), true ) ? $sort : 'rand';

        $similar = $this->recommendations->get_similar_by_grape( $product->get_id(), $count, $sort );

        if ( empty( $similar ) ) {
            return;
        }

        $this->helpers->get_template(
            'wine-recommendations.php',
            array(
                'current_product' => $product,
                'similar'         => $similar,
            )
        );
    }
}
