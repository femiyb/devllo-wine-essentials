<?php
/**
 * WooCommerce settings integration for Devllo Wine Essentials.
 */

namespace Devllo\WineEssentials;

class Settings {

    /**
     * Settings field definitions.
     */
    public function get_fields() {
        return array(
            array(
                'title'   => __( 'Enable wine profile', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_enable_profile',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Show Wine Profile block on product pages.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Show highlights', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_highlights',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display wine highlights text if present.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Wine profile position', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_profile_position',
                'default' => 'after_summary',
                'type'    => 'select',
                'options' => array(
                    'before_summary' => __( 'Before product summary', 'devllo-wine-essentials' ),
                    'after_summary'  => __( 'After product summary', 'devllo-wine-essentials' ),
                    'after_tabs'     => __( 'After product tabs', 'devllo-wine-essentials' ),
                ),
                'desc'    => __( 'Choose where the Wine Profile appears.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Enable similar wines', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_enable_similar',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display two similar wines based on grape.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Similar wines count', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_similar_count',
                'default' => 2,
                'type'    => 'select',
                'options' => array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                ),
                'desc'    => __( 'Number of similar wines to show (1-3).', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Similar wines sorting', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_similar_sort',
                'default' => 'rand',
                'type'    => 'select',
                'options' => array(
                    'rand'       => __( 'Random', 'devllo-wine-essentials' ),
                    'price'      => __( 'Price: Low to High', 'devllo-wine-essentials' ),
                    'price-desc' => __( 'Price: High to Low', 'devllo-wine-essentials' ),
                ),
                'desc'    => __( 'Basic sort options for similar wines.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Enable comparison', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_enable_compare',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Allow add-to-compare buttons and shortcode output.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Show compare button on product page', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_compare_show_single',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display compare button on single product pages.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Show compare button on archive', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_compare_show_archive',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display compare button on shop/archive listings.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Comparison page', 'devllo-wine-essentials' ),
                'desc'    => __( 'Select the page where the [devllowine_compare] shortcode is placed.', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_compare_page_id',
                'type'    => 'single_select_page',
                'class'   => 'wc-enhanced-select',
                'default' => '',
            ),
            array(
                'title'   => __( 'Comparison table title', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_compare_title',
                'default' => __( 'Wine Comparison', 'devllo-wine-essentials' ),
                'type'    => 'text',
                'desc'    => __( 'Heading shown above the comparison table.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Empty compare message', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_compare_empty_text',
                'default' => __( 'Add two wines to compare.', 'devllo-wine-essentials' ),
                'type'    => 'text',
                'desc'    => __( 'Message when no wines are in the compare list.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Show in Wine Profile', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_fields_heading',
                'type'    => 'heading',
            ),
            array(
                'title'   => __( 'Vintage', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_vintage',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display vintage field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Region', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_region',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display region field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Grape', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_grape',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display grape field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Body', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_body',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display body field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Sweetness', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_sweetness',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display sweetness field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Aroma', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_aroma',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display aroma field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Winery', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_winery',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display winery field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Wine of origin / Appellation', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_appellation',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display appellation field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Wine type', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_wine_type',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display wine type field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Producer', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_producer',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display producer field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Drinking style', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_drinking_style',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display drinking style field.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'ABV', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_abv',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display alcohol percentage.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Pairs with', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_pairs_with',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display pairing suggestions.', 'devllo-wine-essentials' ),
            ),
            array(
                'title'   => __( 'Badges', 'devllo-wine-essentials' ),
                'id'      => 'devllowine_show_badge',
                'default' => 'yes',
                'type'    => 'checkbox',
                'desc'    => __( 'Display wine badge on shop and single.', 'devllo-wine-essentials' ),
            ),
        );
    }

    /**
     * Persist settings safely.
     */
    public function save( $data ) {
        foreach ( $this->get_fields() as $field ) {
            $id   = $field['id'];
            $type = $field['type'];
            $val  = '';

            if ( 'heading' === $type ) {
                continue;
            }

            if ( 'checkbox' === $type ) {
                $val = isset( $data[ $id ] ) && 'yes' === $data[ $id ] ? 'yes' : 'no';
            } elseif ( 'single_select_page' === $type ) {
                $val = isset( $data[ $id ] ) ? absint( $data[ $id ] ) : '';
            } elseif ( 'select' === $type ) {
                $val = isset( $data[ $id ] ) ? sanitize_text_field( $data[ $id ] ) : $field['default'];
            } else {
                $val = isset( $data[ $id ] ) ? sanitize_text_field( $data[ $id ] ) : $field['default'];
            }

            update_option( $id, $val );
        }
    }
}
