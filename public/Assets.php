<?php
/**
 * Handle public-facing assets.
 */

namespace Devllo\WineEssentials\Frontend;

use Devllo\WineEssentials\Helpers;

class Assets {

    /**
     * @var Helpers
     */
    protected $helpers;

    public function __construct( Helpers $helpers ) {
        $this->helpers = $helpers;
    }

    /**
     * Enqueue styles and scripts for the frontend.
     */
    public function enqueue_assets() {
        if ( is_admin() ) {
            return;
        }

        $compare_page_id = get_option( 'devllowine_compare_page_id', 0 );
        $is_compare_page = $compare_page_id && is_page( $compare_page_id );

        if ( ! is_product() && ! is_shop() && ! is_product_category() && ! is_product_tag() && ! $is_compare_page ) {
            return;
        }

        wp_enqueue_style( 'devllowine-public', DEVLLOWINE_PLUGIN_URL . 'assets/css/dwe-public.css', array(), DEVLLOWINE_VERSION );
        wp_enqueue_script( 'devllowine-public', DEVLLOWINE_PLUGIN_URL . 'assets/js/dwe-public.js', array(), DEVLLOWINE_VERSION, true );

        wp_localize_script(
            'devllowine-public',
            'devllowineCompare',
            array(
                'comparePage' => (int) get_option( 'devllowine_compare_page_id', 0 ),
                'enabled'     => $this->helpers->is_enabled( 'devllowine_enable_compare' ),
            )
        );
    }
}
