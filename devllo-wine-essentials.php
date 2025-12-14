<?php
/**
 * Plugin Name: Devllo Wine Essentials - Wine Product Profiles for WooCommerce
 * Description: Adds wine profile details, recommendations, and comparison tools to WooCommerce products.
 * Version: 1.0.0
 * Author: Devllo
 * Text Domain: devllo-wine-essentials
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DWE_VERSION', '0.1' );
define( 'DWE_PLUGIN_FILE', __FILE__ );
define( 'DWE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DWE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer autoloader if present.
if ( file_exists( DWE_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once DWE_PLUGIN_DIR . 'vendor/autoload.php';
}

/**
 * Fallback autoloader for environments without Composer.
 */
spl_autoload_register(
	function ( $class ) {
		if ( 0 !== strpos( $class, 'Devllo\\WineEssentials\\' ) ) {
			return;
		}

		$prefixes = array(
			'Devllo\\WineEssentials\\Admin\\'    => 'admin/',
			'Devllo\\WineEssentials\\Frontend\\' => 'public/',
			'Devllo\\WineEssentials\\'           => 'includes/',
		);

		foreach ( $prefixes as $prefix => $dir ) {
			if ( 0 === strpos( $class, $prefix ) ) {
				$relative = str_replace( '\\', '/', substr( $class, strlen( $prefix ) ) );
				$candidates = array(
					DWE_PLUGIN_DIR . $dir . $relative . '.php',
					DWE_PLUGIN_DIR . $dir . 'class-' . strtolower( $relative ) . '.php',
					DWE_PLUGIN_DIR . $dir . 'class-dwe-' . strtolower( $relative ) . '.php',
				);
				foreach ( $candidates as $file ) {
					if ( file_exists( $file ) ) {
						require_once $file;
						break 2;
					}
				}
				break;
			}
		}
	}
);

/**
 * Begins execution of the plugin.
 */
function run_devllo_wine_essentials() {
    $plugin = new Devllo_Wine_Essentials();
    $plugin->run();
}

add_action( 'plugins_loaded', 'run_devllo_wine_essentials' );

/**
 * Core plugin class used to define hooks.
 */
class Devllo_Wine_Essentials {

    /**
     * Loader instance.
     *
     * @var \Devllo\WineEssentials\Loader
     */
    protected $loader;

    /**
     * Unique identifier for plugin.
     *
     * @var string
     */
    protected $plugin_name = 'devllo-wine-essentials';

    /**
     * Initialize and set up hooks.
     */
    public function __construct() {
        $this->loader = new Devllo\WineEssentials\Loader();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Register admin area hooks.
     */
    private function define_admin_hooks() {
        $settings    = new Devllo\WineEssentials\Settings();
        $metaboxes   = new Devllo\WineEssentials\Admin\Metaboxes();
        $admin       = new Devllo\WineEssentials\Admin\Admin( $settings, $metaboxes );

        $this->loader->add_action( 'admin_menu', $admin, 'register_menu' );
        $this->loader->add_action( 'admin_init', $admin, 'maybe_save_settings' );
        $this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_assets' );
        $this->loader->add_action( 'wp_ajax_dwe_save_settings', $admin, 'ajax_save_settings' );
        $this->loader->add_filter( 'woocommerce_product_data_tabs', $metaboxes, 'add_wine_details_tab' );
        $this->loader->add_action( 'woocommerce_product_data_panels', $metaboxes, 'render_wine_details_panel' );
        $this->loader->add_action( 'woocommerce_admin_process_product_object', $metaboxes, 'save_wine_metadata' );
    }

    /**
     * Register public-facing hooks.
     */
    private function define_public_hooks() {
        $helpers         = new Devllo\WineEssentials\Helpers();
        $recommendations = new Devllo\WineEssentials\Recommendations();
        $display         = new Devllo\WineEssentials\Frontend\Display( $helpers, $recommendations );
        $compare         = new Devllo\WineEssentials\Frontend\Compare( $helpers );
        $public          = new Devllo\WineEssentials\Frontend\Assets( $helpers );
        $blocks          = new Devllo\WineEssentials\Blocks( $helpers );

        $this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_assets' );

        $position = $helpers->get_option( 'dwe_profile_position', 'after_summary' );
        if ( 'before_summary' === $position ) {
            $this->loader->add_action( 'woocommerce_single_product_summary', $display, 'display_wine_profile', 5 );
        } elseif ( 'after_tabs' === $position ) {
            $this->loader->add_action( 'woocommerce_after_single_product_summary', $display, 'display_wine_profile', 30 );
        } else {
            $this->loader->add_action( 'woocommerce_single_product_summary', $display, 'display_wine_profile', 25 );
        }

        $this->loader->add_action( 'woocommerce_after_single_product_summary', $display, 'display_similar_wines', 12 );

        $this->loader->add_action( 'woocommerce_before_shop_loop_item_title', $display, 'display_badge_archive', 4 );
        $this->loader->add_action( 'woocommerce_before_single_product_summary', $display, 'display_badge_single', 4 );
        $this->loader->add_action( 'woocommerce_after_shop_loop_item', $compare, 'add_compare_button', 20 );
        $this->loader->add_action( 'woocommerce_single_product_summary', $compare, 'add_compare_button_single', 35 );
        $this->loader->add_action( 'init', $compare, 'maybe_handle_request' );
        $this->loader->add_action( 'init', $compare, 'register_shortcode' );
        $this->loader->add_action( 'init', $blocks, 'register_blocks' );
    }

    /**
     * Run the loader to execute hooks.
     */
    public function run() {
        $this->loader->run();
    }
}
