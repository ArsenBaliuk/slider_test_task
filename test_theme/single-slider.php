<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php
    $slide_id = get_the_ID();
    $title = get_the_title($slide_id);
    $image = get_the_post_thumbnail_url($slide_id, 'full');
    $description = get_post_meta($slide_id, 'description', true);
    ?>

    <div class="single-slide">
        <div class="title"><?php echo $title; ?></div>
        <img width="500px" src="<?php echo $image; ?>" alt="" class="image">
        <div class="desc"><?php echo $description; ?></div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>