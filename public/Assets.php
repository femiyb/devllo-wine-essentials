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

        wp_enqueue_style( 'dwe-public', DWE_PLUGIN_URL . 'assets/css/dwe-public.css', array(), DWE_VERSION );
        wp_enqueue_script( 'dwe-public', DWE_PLUGIN_URL . 'assets/js/dwe-public.js', array( 'jquery' ), DWE_VERSION, true );

        wp_localize_script(
            'dwe-public',
            'dweCompare',
            array(
                'comparePage' => (int) get_option( 'dwe_compare_page_id', 0 ),
                'enabled'     => $this->helpers->is_enabled( 'dwe_enable_compare' ),
            )
        );
    }
}
