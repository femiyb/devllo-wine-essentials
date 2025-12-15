<?php
/** @var array $fields */
/** @var WC_Product|null $product */
?>
<div id="dwe_wine_details_data" class="panel woocommerce_options_panel hidden">
    <div class="options_group">
        <?php
        wp_nonce_field( 'dwe_save_wine_meta', 'dwe_wine_meta_nonce' );

        foreach ( $fields as $field ) {
            $value = $product ? $product->get_meta( $field['id'], true ) : '';

            if ( 'select' === $field['type'] ) {
                woocommerce_wp_select(
                    array(
                        'id'      => $field['id'],
                        'label'   => esc_html( $field['label'] ),
                        'options' => $field['options'],
                        'value'   => $value,
                    )
                );
            } elseif ( 'textarea' === $field['type'] ) {
                woocommerce_wp_textarea_input(
                    array(
                        'id'          => $field['id'],
                        'label'       => esc_html( $field['label'] ),
                        'value'       => $value,
                        'description' => '',
                        'rows'        => 3,
                    )
                );
            } else {
                woocommerce_wp_text_input(
                    array(
                        'id'          => $field['id'],
                        'label'       => esc_html( $field['label'] ),
                        'value'       => $value,
                        'type'        => $field['type'],
                        'data_type'   => 'number' === $field['type'] ? 'decimal' : 'text',
                        'description' => '',
                    )
                );
            }
        }
        ?>
    </div>
</div>
