<?php
/**
 * Lightweight comparison list handling.
 */

namespace Devllo\WineEssentials\Frontend;

use Devllo\WineEssentials\Helpers;
use WC_Product;

class Compare {

    /**
     * @var Helpers
     */
    protected $helpers;

    public function __construct( Helpers $helpers ) {
        $this->helpers = $helpers;
    }

    /**
     * Register shortcode for comparison table.
     */
    public function register_shortcode() {
        add_shortcode( 'dwe_compare', array( $this, 'shortcode_compare' ) );
    }

    /**
     * Handle add/remove requests via query string.
     */
    public function maybe_handle_request() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_compare' ) ) {
            return;
        }

        if ( empty( $_GET['dwe_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['dwe_nonce'] ) ), 'dwe_compare_action' ) ) {
            return;
        }

        if ( is_admin() && ! wp_doing_ajax() ) {
            return;
        }

        $should_redirect = false;

        if ( isset( $_GET['dwe_add_compare'] ) ) {
            $product_id = absint( $_GET['dwe_add_compare'] );
            if ( $product_id ) {
                $this->add_to_compare( $product_id );
                $should_redirect = true;
            }
        }

        if ( isset( $_GET['dwe_remove_compare'] ) ) {
            $product_id = absint( $_GET['dwe_remove_compare'] );
            if ( $product_id ) {
                $this->remove_from_compare( $product_id );
                $should_redirect = true;
            }
        }

        if ( $should_redirect && ! headers_sent() ) {
            wp_safe_redirect( remove_query_arg( array( 'dwe_add_compare', 'dwe_remove_compare' ) ) );
            exit;
        }
    }

    /**
     * Output compare button on catalog items.
     */
    public function add_compare_button() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_compare' ) ) {
            return;
        }

        if ( ! $this->helpers->is_enabled( 'dwe_compare_show_archive' ) ) {
            return;
        }

        global $product;

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $product_id   = $product->get_id();
        if ( ! $this->helpers->has_wine_meta( $product_id ) ) {
            return;
        }
        $compare_list = $this->get_compare_list();
        $in_compare   = in_array( $product_id, $compare_list, true );

        $label = $in_compare ? __( 'In Compare', 'devllo-wine-essentials' ) : __( 'Add to Compare', 'devllo-wine-essentials' );
        $url   = $in_compare ? add_query_arg( 'dwe_remove_compare', $product_id ) : add_query_arg( 'dwe_add_compare', $product_id );
        $url   = add_query_arg( 'dwe_nonce', $this->get_action_nonce(), $url );

        echo '<a class="button add_to_cart_button dwe-add-compare" href="' . esc_url( $url ) . '" data-product-id="' . esc_attr( $product_id ) . '">' . esc_html( $label ) . '</a>';
    }

    /**
     * Output compare button on single product page.
     */
    public function add_compare_button_single() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_compare' ) ) {
            return;
        }

        if ( ! $this->helpers->is_enabled( 'dwe_compare_show_single' ) ) {
            return;
        }

        global $product;

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $product_id   = $product->get_id();
        if ( ! $this->helpers->has_wine_meta( $product_id ) ) {
            return;
        }
        $compare_list = $this->get_compare_list();
        $in_compare   = in_array( $product_id, $compare_list, true );

        $label = $in_compare ? __( 'In Compare', 'devllo-wine-essentials' ) : __( 'Add to Compare', 'devllo-wine-essentials' );
        $url   = $in_compare ? add_query_arg( 'dwe_remove_compare', $product_id ) : add_query_arg( 'dwe_add_compare', $product_id );
        $url   = add_query_arg( 'dwe_nonce', $this->get_action_nonce(), $url );

        echo '<p class="dwe-single-compare"><a class="button add_to_cart_button dwe-add-compare" href="' . esc_url( $url ) . '" data-product-id="' . esc_attr( $product_id ) . '">' . esc_html( $label ) . '</a></p>';
    }

    /**
     * Render comparison table shortcode.
     */
    public function shortcode_compare() {
        if ( ! $this->helpers->is_enabled( 'dwe_enable_compare' ) ) {
            return '';
        }

        $product_ids = $this->get_compare_list();

        if ( empty( $product_ids ) ) {
            $empty = $this->helpers->get_option( 'dwe_compare_empty_text', __( 'Add two wines to compare.', 'devllo-wine-essentials' ) );
            return '<p>' . esc_html( $empty ) . '</p>';
        }

        $products = array();
        foreach ( $product_ids as $product_id ) {
            $product = wc_get_product( $product_id );
            if ( $product ) {
                $products[] = $product;
            }
        }

        if ( empty( $products ) ) {
            return '';
        }

        ob_start();
        $this->helpers->get_template(
            'wine-compare-table.php',
            array(
                'products' => $products,
                'title'    => $this->helpers->get_option( 'dwe_compare_title', __( 'Wine Comparison', 'devllo-wine-essentials' ) ),
                'fields'   => $this->get_compare_fields(),
            )
        );
        return ob_get_clean();
    }

    /**
     * Build comparison fields respecting settings.
     */
    protected function get_compare_fields() {
        $fields = array();
        $maybe_add = function ( $id, $label, $meta_key ) use ( &$fields ) {
            if ( $this->helpers->is_enabled( 'dwe_show_' . $id ) ) {
                $fields[ $label ] = $meta_key;
            }
        };

        $maybe_add( 'wine_type', __( 'Wine Type', 'devllo-wine-essentials' ), '_dwe_wine_type' );
        $maybe_add( 'vintage', __( 'Vintage', 'devllo-wine-essentials' ), '_dwe_vintage' );
        $maybe_add( 'producer', __( 'Producer', 'devllo-wine-essentials' ), '_dwe_producer' );
        $maybe_add( 'winery', __( 'Winery', 'devllo-wine-essentials' ), '_dwe_winery' );
        $maybe_add( 'region', __( 'Region', 'devllo-wine-essentials' ), '_dwe_region' );
        $maybe_add( 'appellation', __( 'Wine of origin', 'devllo-wine-essentials' ), '_dwe_appellation' );
        $maybe_add( 'grape', __( 'Grape', 'devllo-wine-essentials' ), '_dwe_grape' );
        $maybe_add( 'aroma', __( 'Aroma', 'devllo-wine-essentials' ), '_dwe_aroma' );
        $maybe_add( 'body', __( 'Body', 'devllo-wine-essentials' ), '_dwe_body' );
        $maybe_add( 'sweetness', __( 'Sweetness', 'devllo-wine-essentials' ), '_dwe_sweetness' );
        $maybe_add( 'drinking_style', __( 'Drinking style', 'devllo-wine-essentials' ), '_dwe_drinking_style' );
        $maybe_add( 'abv', __( 'ABV', 'devllo-wine-essentials' ), '_dwe_abv' );

        return $fields;
    }

    /**
     * Add product to comparison list (max 2 items).
     */
    protected function add_to_compare( $product_id ) {
        $list   = $this->get_compare_list();
        $list[] = $product_id;

        $list = array_values( array_unique( array_map( 'absint', $list ) ) );
        $list = array_slice( $list, -2 );

        $this->set_compare_list( $list );
    }

    /**
     * Remove product from comparison list.
     */
    protected function remove_from_compare( $product_id ) {
        $list = array_filter(
            $this->get_compare_list(),
            function ( $id ) use ( $product_id ) {
                return absint( $id ) !== absint( $product_id );
            }
        );

        $this->set_compare_list( array_values( $list ) );
    }

    /**
     * Retrieve list from WooCommerce session or PHP session.
     */
    protected function get_compare_list() {
        $list = array();

        if ( function_exists( 'WC' ) && WC()->session ) {
            $list = WC()->session->get( 'dwe_compare_list', array() );
        } else {
            if ( ! session_id() ) {
                if ( headers_sent() ) {
                    return array();
                }
                session_start();
            }
            $list = isset( $_SESSION['dwe_compare_list'] )
            ? (array) ( $_SESSION['dwe_compare_list'] )
            : array();
        }

        if ( ! is_array( $list ) ) {
            $list = array();
        }

        $list = array_values( array_unique( array_map( 'absint', $list ) ) );

        if ( count( $list ) > 2 ) {
            $list = array_slice( $list, -2 );
        }

        return $list;
    }

    /**
     * Store list in a session container.
     */
    protected function set_compare_list( $list ) {
        $list = array_slice( array_values( array_unique( array_map( 'absint', (array) $list ) ) ), -2 );

        if ( function_exists( 'WC' ) && WC()->session ) {
            WC()->session->set( 'dwe_compare_list', $list );
        } else {
            if ( ! session_id() ) {
                if ( headers_sent() ) {
                    return;
                }
                session_start();
            }
            $_SESSION['dwe_compare_list'] = $list;
        }
    }

    /**
     * Build action nonce for compare operations.
     */
    protected function get_action_nonce() {
        return wp_create_nonce( 'dwe_compare_action' );
    }
}
