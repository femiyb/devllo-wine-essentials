<?php
/**
 * Admin controller for settings and metaboxes.
 */

namespace Devllo\WineEssentials\Admin;

use Devllo\WineEssentials\Settings;
use Devllo\WineEssentials\Admin\Metaboxes;

class Admin {

    /**
     * Settings handler.
     *
     * @var Settings
     */
    protected $settings;

    /**
     * Metabox handler.
     *
     * @var Metaboxes
     */
    protected $metaboxes;

    /**
     * Constructor.
     */
    public function __construct( Settings $settings, Metaboxes $metaboxes ) {
        $this->settings  = $settings;
        $this->metaboxes = $metaboxes;
    }

    /**
     * Register submenu under WooCommerce.
     */
    public function register_menu() {
        add_submenu_page(
            'woocommerce',
            __( 'Wine Essentials', 'devllo-wine-essentials' ),
            __( 'Wine Essentials', 'devllo-wine-essentials' ),
            'manage_woocommerce',
            'dwe-wine-essentials',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Handle settings form submission (legacy fallback).
     */
    public function maybe_save_settings() {
        if ( ! isset( $_POST['dwe_settings_nonce'] ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( sanitize_key( $_POST['dwe_settings_nonce'] ), 'dwe_save_settings' ) ) {
            return;
        }

        $this->settings->save( $_POST );
        add_settings_error( 'dwe_settings', 'dwe_saved', __( 'Settings saved.', 'devllo-wine-essentials' ), 'updated' );
    }

    /**
     * Render admin settings page (React root).
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        settings_errors( 'dwe_settings' );
        ?>
        <div class="wrap dwe-settings-wrap">
            <h1><?php esc_html_e( 'Wine Essentials', 'devllo-wine-essentials' ); ?></h1>
            <p class="dwe-settings-lede"><?php esc_html_e( 'Adjust wine profile placement, similar wines, and compare controls.', 'devllo-wine-essentials' ); ?></p>
            <div id="dwe-settings-root"></div>
            <noscript><?php esc_html_e( 'This screen requires JavaScript enabled.', 'devllo-wine-essentials' ); ?></noscript>
        </div>
        <?php
    }

    /**
     * Enqueue admin assets.
     */
    public function enqueue_assets( $hook ) {
        if ( 'woocommerce_page_dwe-wine-essentials' !== $hook ) {
            return;
        }

        wp_enqueue_style( 'dwe-admin', DWE_PLUGIN_URL . 'assets/css/dwe-admin.css', array(), DWE_VERSION );
        wp_enqueue_script(
            'dwe-admin-react',
            DWE_PLUGIN_URL . 'assets/js/dwe-admin.js',
            array( 'wp-element', 'wp-api-fetch' ),
            DWE_VERSION,
            true
        );

        $fields = $this->settings->get_fields();
        foreach ( $fields as &$field ) {
            if ( isset( $field['type'] ) && 'single_select_page' === $field['type'] ) {
                $pages         = get_pages();
                $field['options'] = array( '' => __( 'Select a page', 'devllo-wine-essentials' ) );
                foreach ( $pages as $page ) {
                    $field['options'][ $page->ID ] = $page->post_title;
                }
            }
        }
        unset( $field );
        $values = array();
        foreach ( $fields as $field ) {
            if ( isset( $field['id'] ) ) {
                $default                 = isset( $field['default'] ) ? $field['default'] : '';
                $values[ $field['id'] ]  = get_option( $field['id'], $default );
            }
        }

        wp_localize_script(
            'dwe-admin-react',
            'dweSettingsData',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'dwe_save_settings' ),
                'fields'  => $fields,
                'values'  => $values,
            )
        );
    }

    /**
     * Handle AJAX save from React UI.
     */
    public function ajax_save_settings() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'devllo-wine-essentials' ) ), 403 );
        }

        check_ajax_referer( 'dwe_save_settings', 'nonce' );
        
        $data = isset( $_POST['settings'] )
        ? (array) wp_unslash( $_POST['settings'] )
        : array();

        wp_send_json_success( array( 'message' => __( 'Settings saved.', 'devllo-wine-essentials' ) ) );
    }
}
