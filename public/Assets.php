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

        wp_enqueue_style( 'devllowine-public', DEVLLOWINE_PLUGIN_URL . 'assets/css/dwe-public.css', array(), DEVLLOWINE_VERSION );
        wp_enqueue_script( 'devllowine-public', DEVLLOWINE_PLUGIN_URL . 'assets/js/dwe-public.js', array( 'jquery' ), DEVLLOWINE_VERSION, true );

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
