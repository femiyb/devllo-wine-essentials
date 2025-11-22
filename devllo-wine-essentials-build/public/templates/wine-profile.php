<?php defined( 'ABSPATH' ) || exit; ?>
<section class="dwe-wine-profile">
    <h3 class="dwe-wine-profile__title"><?php esc_html_e( 'Wine Profile', 'devllo-wine-essentials' ); ?></h3>

    <?php if ( in_array( 'highlights', $allowed_fields, true ) && ! empty( $meta['highlights'] ) ) : ?>
        <p class="dwe-wine-profile__highlights"><?php echo esc_html( $meta['highlights'] ); ?></p>
    <?php endif; ?>

    <dl class="dwe-wine-profile__grid">
        <?php if ( in_array( 'wine_type', $allowed_fields, true ) && ! empty( $meta['wine_type'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Wine Type', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['wine_type'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'vintage', $allowed_fields, true ) && ! empty( $meta['vintage'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Vintage', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['vintage'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'winery', $allowed_fields, true ) && ! empty( $meta['winery'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Winery', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['winery'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'producer', $allowed_fields, true ) && ! empty( $meta['producer'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Producer', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['producer'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'region', $allowed_fields, true ) && ! empty( $meta['region'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Region', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['region'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'appellation', $allowed_fields, true ) && ! empty( $meta['appellation'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Wine of origin', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['appellation'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'grape', $allowed_fields, true ) && ! empty( $meta['grape'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Grape', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['grape'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'drinking_style', $allowed_fields, true ) && ! empty( $meta['drinking_style'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Drinking style', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['drinking_style'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'aroma', $allowed_fields, true ) && ! empty( $meta['aroma'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Aroma', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['aroma'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'body', $allowed_fields, true ) && ! empty( $meta['body'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Body', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['body'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'sweetness', $allowed_fields, true ) && ! empty( $meta['sweetness'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'Sweetness', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['sweetness'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( in_array( 'abv', $allowed_fields, true ) && ! empty( $meta['abv'] ) ) : ?>
            <div class="dwe-wine-profile__item">
                <dt><?php esc_html_e( 'ABV', 'devllo-wine-essentials' ); ?></dt>
                <dd><?php echo esc_html( $meta['abv'] ); ?>%</dd>
            </div>
        <?php endif; ?>
    </dl>

    <?php if ( in_array( 'pairs_with', $allowed_fields, true ) && ! empty( $meta['pairs_with'] ) ) : ?>
        <div class="dwe-wine-profile__section">
            <h4><?php esc_html_e( 'Pairs with', 'devllo-wine-essentials' ); ?></h4>
            <p><?php echo esc_html( $meta['pairs_with'] ); ?></p>
        </div>
    <?php endif; ?>
</section>
