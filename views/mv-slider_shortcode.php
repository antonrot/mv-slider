<h3><?php echo ( ! empty ( $content ) ) ? esc_html( $content ) : ''; ?></h3>
<div class="mv-slider flexslider ">
    <ul class="slides">
        <?php
            $args = [
                'post_type' => 'mv-slider',
                'post_status' => 'publish',
                'meta_key' => 'mv_slider_name',
                'meta_value' => $slider_name,
                'order_by' => $order_by
            ];
            //var_dump($slider_name);
            $sliders_query = new WP_Query($args);
        ?>
        <?php
        if ($sliders_query->have_posts()) :
            while($sliders_query->have_posts()) : $sliders_query->the_post();
                $link_text = get_post_meta( $sliders_query->post->ID, 'mv_slider_link_text', true );
                $link_url = get_post_meta( $sliders_query->post->ID, 'mv_slider_link_url', true );
        ?>
        <li>
            <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
            <div class="mvs-container">
                <div class="slider-details-container">
                    <div class="wrapper">
                        <div class="slider-title">
                            <h2><?php the_title() ?></h2>
                        </div>
                        <div class="slider-description">
                            <div class="subtitle"><?php the_content() ?></div>
                            <a class="link" href="<?php echo $link_url ?>"><?php echo $link_text ?></a>
                        </div>
                    </div>
                </div>              
            </div>
        </li>
        <?php
        endwhile;
        endif;
        ?>
    </ul>
</div>