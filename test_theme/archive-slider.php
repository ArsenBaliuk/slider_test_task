<?php get_header(); ?>

<?php

$args = array(
    'post_type' => 'slider',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date'
);


$query = new WP_Query( $args );

?>

<main class="slider-archive">
<div class="container">

    <?php if($query->have_posts()): ?>

        <div class="swiper swiper-slider">

            <div class="swiper-wrapper slider-wrapper">

                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                    $slide_id = get_the_ID();
                    $title = get_the_title($slide_id);
                    $image = get_the_post_thumbnail_url($slide_id, 'full');
                    $description = get_post_meta($slide_id, 'description', true);
                    ?>

                    <div class="swiper-slide single-slide">
                        <div class="title"><?php echo $title; ?></div>
                        <img width="500px" height="700px" src="<?php echo $image; ?>" alt="" class="image">
                    </div>

                <?php endwhile; wp_reset_postdata(); ?>

            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>

    <?php endif; ?>

</div>
</main>


<?php get_footer(); ?>