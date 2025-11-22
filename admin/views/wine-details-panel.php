<?php
/** @var array $fields */
/** @var WC_Product|null $product */
?>
<div id="dwe_wine_details_data" class="panel woocommerce_options_panel hidden">
    <div class="options_group">
        <?php
        foreach ( $fields as $field ) {
            $value = $product ? $product->get_meta( $field['id'], true ) : '';

            if ( 'select' === $field['type'] ) {
                $options = array();
                foreach ( $field['options'] as $opt_value => $opt_label ) {
                    $options[ $opt_value ] = __( $opt_label, 'devllo-wine-essentials' );
                }

                woocommerce_wp_select(
                    array(
                        'id'      => $field['id'],
                        'label'   => esc_html__( $field['label'], 'devllo-wine-essentials' ),
                        'options' => $options,
                        'value'   => $value,
                    )
                );
            } elseif ( 'textarea' === $field['type'] ) {
                woocommerce_wp_textarea_input(
                    array(
                        'id'          => $field['id'],
                        'label'       => esc_html__( $field['label'], 'devllo-wine-essentials' ),
                        'value'       => $value,
                        'description' => '',
                        'rows'        => 3,
                    )
                );
            } else {
                woocommerce_wp_text_input(
                    array(
                        'id'          => $field['id'],
                        'label'       => esc_html__( $field['label'], 'devllo-wine-essentials' ),
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
