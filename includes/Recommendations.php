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
            'limit'      => $limit,
            'exclude'    => array( $product_id ),
            'meta_query' => array(
                array(
                    'key'   => '_dwe_grape',
                    'value' => $grape,
                ),
            ),
            'orderby'    => $orderby,
            'order'      => $order,
            'return'     => 'objects',
        );

        return wc_get_products( $args );
    }
}
