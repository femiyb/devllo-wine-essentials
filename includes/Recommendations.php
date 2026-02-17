<?php
/**
 * Very light recommendation helper using grape match.
 */

namespace Devllo\WineEssentials;

class Recommendations {

    /**
     * Get similar wines based on shared grape varietal.
     */
    public function get_similar_by_grape( $product_id, $limit = 2, $orderby = 'rand' ) {
        $grape = get_post_meta( $product_id, '_dwe_grape', true );

        if ( empty( $grape ) || ! function_exists( 'wc_get_products' ) ) {
            return array();
        }

        $order = 'ASC';
        if ( 'price-desc' === $orderby ) {
            $order   = 'DESC';
            $orderby = 'price';
        }

        $args = array(
            'status'     => 'publish',
            'limit'      => $limit + 1, // fetch one extra in case current product is in results.
            'meta_key'   => '_dwe_grape', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
            'meta_value' => $grape, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
            'orderby'    => $orderby,
            'order'      => $order,
            'return'     => 'objects',
        );

        $products = wc_get_products( $args );

        $products = array_filter(
            $products,
            function ( $candidate ) use ( $product_id ) {
                return (int) $candidate->get_id() !== (int) $product_id;
            }
        );

        return array_slice( array_values( $products ), 0, $limit );
    }
}
