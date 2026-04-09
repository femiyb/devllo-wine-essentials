<?php defined( 'ABSPATH' ) || exit; ?>
<?php // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>

<div class="dwe-compare-wrapper">

    <?php if ( empty( $products ) ) : ?>
        <p><?php echo esc_html( $empty ); ?></p>
    <?php else : ?>

    <table class="dwe-compare__table">

        <thead>
            <tr>
                <th class="dwe-compare__corner"></th>
                <?php foreach ( $products as $product ) : ?>
                    <th class="dwe-compare__product-col">
                        <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="dwe-compare__product-image">
                            <?php echo $product->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </a>
                        <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="dwe-compare__product-name">
                            <?php echo esc_html( $product->get_name() ); ?>
                        </a>
                        <?php if ( $product->get_price_html() ) : ?>
                            <div class="dwe-compare__product-price">
                                <?php echo wp_kses_post( $product->get_price_html() ); ?>
                            </div>
                        <?php endif; ?>
                        <a class="dwe-compare__remove"
                           href="<?php echo esc_url( add_query_arg( array(
                               'devllowine_remove_compare' => $product->get_id(),
                               'devllowine_nonce'          => wp_create_nonce( 'devllowine_compare_action' ),
                           ) ) ); ?>">
                            <?php esc_html_e( 'Remove', 'devllo-wine-essentials' ); ?>
                        </a>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ( $fields as $label => $meta_key ) : ?>
                <?php
                $is_scale = in_array( $meta_key, array( '_dwe_body', '_dwe_sweetness' ), true );
                $scale_map = array(
                    '_dwe_body'      => array( 'Light' => 33, 'Medium' => 66, 'Full' => 100 ),
                    '_dwe_sweetness' => array( 'Dry' => 33, 'Semi' => 66, 'Sweet' => 100 ),
                );
                ?>
                <tr>
                    <th scope="row" class="dwe-compare__label"><?php echo esc_html( $label ); ?></th>
                    <?php foreach ( $products as $product ) : ?>
                        <?php $value = get_post_meta( $product->get_id(), $meta_key, true ); ?>
                        <td class="dwe-compare__value">
                            <?php if ( ! empty( $value ) ) : ?>
                                <?php echo esc_html( $value ); ?>
                                <?php if ( $is_scale && isset( $scale_map[ $meta_key ][ $value ] ) ) : ?>
                                    <div class="dwe-scale">
                                        <div class="dwe-scale__bar">
                                            <div class="dwe-scale__fill" style="width: <?php echo esc_attr( $scale_map[ $meta_key ][ $value ] ); ?>%"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <span class="dwe-empty">&mdash;</span>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td></td>
                <?php foreach ( $products as $product ) : ?>
                    <td class="dwe-compare__footer-col">
                        <?php
                        echo do_shortcode(
                            '[add_to_cart id="' . esc_attr( $product->get_id() ) . '" show_price="false"]'
                        );
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td></td>
                <td colspan="<?php echo count( $products ); ?>" class="dwe-compare__clear">
                    <a href="<?php echo esc_url( add_query_arg( array(
                        'devllowine_clear_compare' => '1',
                        'devllowine_nonce'         => wp_create_nonce( 'devllowine_compare_action' ),
                    ) ) ); ?>" class="dwe-compare__clear-link">
                        <?php esc_html_e( 'Clear all', 'devllo-wine-essentials' ); ?>
                    </a>
                </td>
            </tr>
        </tfoot>

    </table>

    <?php endif; ?>

</div>

<?php // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>