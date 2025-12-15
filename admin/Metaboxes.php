<?php
/**
 * WooCommerce product data tab for wine details.
 */

namespace Devllo\WineEssentials\Admin;

class Metaboxes {

    /**
     * Meta definitions for wine fields.
     *
     * @var array
     */
    protected $meta_fields = array();

    /**
     * Build meta field definitions at runtime (translation-safe).
     */
    public function __construct() {
        $this->meta_fields = array(
            'highlights' => array(
                'id'    => '_dwe_highlights',
                'label' => 'Highlights',
                'type'  => 'textarea',
            ),
            'wine_type' => array(
                'id'      => '_dwe_wine_type',
                'label'   => 'Wine Type',
                'type'    => 'select',
                'options' => array(
                    ''          => 'Select wine type',
                    'Red'       => 'Red',
                    'White'     => 'White',
                    'Rosé'      => 'Rosé',
                    'Sparkling' => 'Sparkling',
                    'Dessert'   => 'Dessert',
                ),
            ),
            'vintage'   => array(
                'id'    => '_dwe_vintage',
                'label' => 'Vintage',
                'type'  => 'number',
            ),
            'winery'    => array(
                'id'    => '_dwe_winery',
                'label' => 'Winery',
                'type'  => 'text',
            ),
            'region'    => array(
                'id'    => '_dwe_region',
                'label' => 'Region',
                'type'  => 'text',
            ),
            'appellation' => array(
                'id'    => '_dwe_appellation',
                'label' => 'Wine of origin / Appellation',
                'type'  => 'text',
            ),
            'grape'     => array(
                'id'    => '_dwe_grape',
                'label' => 'Grape varietal',
                'type'  => 'text',
            ),
            'badge'    => array(
                'id'      => '_dwe_badge',
                'label'   => 'Wine badge',
                'type'    => 'select',
                'options' => array(
                    ''              => 'No badge',
                    'New'           => 'New',
                    'Best Seller'   => 'Best Seller',
                    'Award Winning' => 'Award Winning',
                    'Limited Stock' => 'Limited Stock',
                ),
            ),
            'drinking_style' => array(
                'id'    => '_dwe_drinking_style',
                'label' => 'Drinking style',
                'type'  => 'text',
            ),
            'aroma'     => array(
                'id'    => '_dwe_aroma',
                'label' => 'Aroma',
                'type'  => 'text',
            ),
            'body'      => array(
                'id'      => '_dwe_body',
                'label'   => 'Body level',
                'type'    => 'select',
                'options' => array(
                    ''       => 'Select a body level',
                    'Light'  => 'Light',
                    'Medium' => 'Medium',
                    'Full'   => 'Full',
                ),
            ),
            'sweetness' => array(
                'id'      => '_dwe_sweetness',
                'label'   => 'Sweetness level',
                'type'    => 'select',
                'options' => array(
                    ''      => 'Select sweetness',
                    'Dry'   => 'Dry',
                    'Semi'  => 'Semi',
                    'Sweet' => 'Sweet',
                ),
            ),
            'producer' => array(
                'id'    => '_dwe_producer',
                'label' => 'Producer',
                'type'  => 'text',
            ),
            'abv' => array(
                'id'    => '_dwe_abv',
                'label' => 'ABV (%)',
                'type'  => 'text',
            ),
            'pairs_with' => array(
                'id'    => '_dwe_pairs_with',
                'label' => 'Pairs with',
                'type'  => 'textarea',
            ),
        );
    }

    /**
     * Add product data tab.
     */
    public function add_wine_details_tab( $tabs ) {
        $tabs['dwe_wine_details'] = array(
            'label'    => __( '🍷 Wine Details', 'devllo-wine-essentials' ),
            'target'   => 'dwe_wine_details_data',
            'class'    => array(),
            'priority' => 70,
        );

        return $tabs;
    }

    /**
     * Render the product data panel content.
     */
    public function render_wine_details_panel() {
        global $post;

        $product = wc_get_product( $post ? $post->ID : 0 );
        $fields  = $this->meta_fields;

        include DWE_PLUGIN_DIR . 'admin/views/wine-details-panel.php';
    }

    /**
     * Save submitted metadata to the product.
     */
    public function save_wine_metadata( $product ) {
        if ( ! isset( $_POST['dwe_wine_meta_nonce'] ) ) {
            return;
        }

        $nonce = sanitize_text_field( wp_unslash( $_POST['dwe_wine_meta_nonce'] ) );
        if ( ! wp_verify_nonce( $nonce, 'dwe_save_wine_meta' ) ) {
            return;
        }

        foreach ( $this->meta_fields as $field ) {
            $raw_value = isset( $_POST[ $field['id'] ] ) ? wp_unslash( $_POST[ $field['id'] ] ) : '';

            if ( 'number' === $field['type'] ) {
                $value = absint( $raw_value );
            } elseif ( 'textarea' === $field['type'] ) {
                $value = sanitize_textarea_field( $raw_value );
            } else {
                $value = sanitize_text_field( $raw_value );
            }

            if ( '_dwe_abv' === $field['id'] ) {
                $value = '' === $value ? '' : rtrim( rtrim( sprintf( '%.2f', (float) $value ), '0' ), '.' );
            }

            if ( ! empty( $value ) ) {
                $product->update_meta_data( $field['id'], $value );
            } else {
                $product->delete_meta_data( $field['id'] );
            }
        }
    }
}
