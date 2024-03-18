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

<?php get_header(); ?>
<main class="wrapper home_page"><span class="opacity-bg"></span>

    <section class="container">

        <div class="home-title">
            <h2>Explore by Room: Tailored Furniture Selections</h2>
        </div>

        <?php if($query->have_posts()): ?>

        <div class="slider-container">

            <div class="swiper swiper-slider">

                <div class="swiper-wrapper slider-wrapper">

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php
                        $slide_id = get_the_ID();
                        $title = get_the_title($slide_id);
                        $image = get_the_post_thumbnail_url($slide_id, 'full');
                        $description = get_post_meta($slide_id, 'description', true);
                        ?>

                        <div class="swiper-slide single-slide" data-id="<?php echo $slide_id; ?>">
                            <div class="title"><?php echo $title; ?></div>
                            <img width="500px" height="700px" src="<?php echo $image; ?>" alt="" class="image">
                        </div>

                    <?php endwhile; wp_reset_postdata(); ?>

                </div>

                <div class="swiper-pagination"></div>

                <div class="swiper-button-prev"><img class="swiper-arrow-button" src="<?php echo get_template_directory_uri(); ?>/img/icons/slider_arrow.svg" alt="Slider arrow"></div>
                <div class="swiper-button-next"><img class="swiper-arrow-button" src="<?php echo get_template_directory_uri(); ?>/img/icons/slider_arrow.svg" alt="Slider arrow"></div>

                <!-- Попап для відображення опису обрагоно слайду за допомогою Ajax запиту -->
                <div class="popup-slider">
                    <div class="popup-container">
                        <div class="close-popup-btn"><img src="<?php echo get_template_directory_uri();?>/img/icons/close-btn.svg" alt="Close popup button"></div>
                        <div class="title">
                            <h3>Description</h3>
                        </div>
                        <div class="popup_wrapper">
                            <div class="card-description card_desc_wrapper">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut facilis fugit nam odio quia quibusdam quod reiciendis voluptatibus! Alias consequuntur ex exercitationem magnam! Architecto cupiditate id ipsam maiores officia voluptatem.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php endif; ?>

    </section>

</main>
<?php get_footer(); ?>
