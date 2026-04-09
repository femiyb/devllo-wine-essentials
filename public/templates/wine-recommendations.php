<?php defined( 'ABSPATH' ) || exit; ?>
<section class="dwe-wine-recommendations">
    <h3 class="dwe-wine-recommendations__title"><?php esc_html_e( 'Similar Wines', 'devllo-wine-essentials' ); ?></h3>
    <div class="dwe-wine-recommendations__grid">
        <?php // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
        <?php foreach ( $similar as $item ) : ?>
            <article class="dwe-wine-card">
                <a href="<?php echo esc_url( get_permalink( $item->get_id() ) ); ?>" class="dwe-wine-card__thumb">
                    <?php echo $item->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </a>
                <div class="dwe-wine-card__body">
                    <h4 class="dwe-wine-card__title">
                        <a href="<?php echo esc_url( get_permalink( $item->get_id() ) ); ?>"><?php echo esc_html( $item->get_name() ); ?></a>
                    </h4>
                    <?php if ( $item->get_price_html() ) : ?>
                        <div class="dwe-wine-card__price"><?php echo wp_kses_post( $item->get_price_html() ); ?></div>
                    <?php endif; ?>
                    <?php
                    $grape   = get_post_meta( $item->get_id(), '_dwe_grape', true );
                    $vintage = get_post_meta( $item->get_id(), '_dwe_vintage', true );
                    $type    = get_post_meta( $item->get_id(), '_dwe_wine_type', true );
                    ?>
                    <?php if ( $type || $vintage ) : ?>
                        <p class="dwe-wine-card__meta">
                            <?php
                            $parts = array_filter( array( $type, $vintage ) );
                            echo esc_html( implode( ' &middot; ', $parts ) );
                            ?>
                        </p>
                    <?php endif; ?>
                    <?php if ( $grape ) : ?>
                        <p class="dwe-wine-card__meta">
                            <?php printf( esc_html__( 'Grape: %s', 'devllo-wine-essentials' ), esc_html( $grape ) ); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
        <?php // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
    </div>
</section>