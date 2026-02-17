<?php defined( 'ABSPATH' ) || exit; ?>
<?php // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
<div class="dwe-compare-wrapper">
    <h3 class="dwe-compare__title"><?php echo esc_html( $title ); ?></h3>
    <table class="dwe-compare__table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Attribute', 'devllo-wine-essentials' ); ?></th>
                <?php foreach ( $products as $product ) : ?>
                    <th>
                        <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
                        <a class="dwe-compare__remove" href="<?php echo esc_url( add_query_arg( array( 'devllowine_remove_compare' => $product->get_id(), 'devllowine_nonce' => wp_create_nonce( 'devllowine_compare_action' ) ) ) ); ?>">&times;</a>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ( empty( $fields ) ) {
                $fields = array(
                    __( 'Vintage', 'devllo-wine-essentials' )   => '_dwe_vintage',
                    __( 'Winery', 'devllo-wine-essentials' )    => '_dwe_winery',
                    __( 'Region', 'devllo-wine-essentials' )    => '_dwe_region',
                    __( 'Wine of origin', 'devllo-wine-essentials' ) => '_dwe_appellation',
                    __( 'Grape', 'devllo-wine-essentials' )     => '_dwe_grape',
                    __( 'Aroma', 'devllo-wine-essentials' )     => '_dwe_aroma',
                    __( 'Body', 'devllo-wine-essentials' )      => '_dwe_body',
                    __( 'Sweetness', 'devllo-wine-essentials' ) => '_dwe_sweetness',
                );
            }
            foreach ( $fields as $label => $meta_key ) : ?>
                <tr>
                    <td><?php echo esc_html( $label ); ?></td>
                    <?php foreach ( $products as $product ) : ?>
                        <?php $value = get_post_meta( $product->get_id(), $meta_key, true ); ?>
                        <td><?php echo $value ? esc_html( $value ) : '&mdash;'; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
