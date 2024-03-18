<?php

add_action('after_setup_theme', 'mytheme_theme_setup');

if ( ! function_exists( 'mytheme_theme_setup' ) ){
    function mytheme_theme_setup(){
        add_action( 'wp_enqueue_scripts', 'mytheme_scripts');
    }

}

if ( ! function_exists( 'mytheme_scripts' ) ){
    function mytheme_scripts() {
        // CSS
        wp_enqueue_style( 'theme_css', get_template_directory_uri().'/css/main.css' );
        wp_enqueue_style( 'custom_css', get_template_directory_uri().'/css/custom.css' );

        // Scripts
        wp_enqueue_script( 'theme_js_2', get_template_directory_uri().'/js/libs/jquery.scrollbar.min.js', array( 'jquery'), '1.0.0', true );
        wp_enqueue_script( 'theme_js_3', get_template_directory_uri().'/js/libs/ion.rangeSlider.min.js', array( 'jquery'), '1.0.0', true );
        wp_enqueue_script( 'theme_js_4', get_template_directory_uri().'/js/libs/jquery.magnific-popup.min.js', array( 'jquery'), '1.0.0', true );
        wp_enqueue_script( 'theme_js_5', get_template_directory_uri().'/js/libs/swiper-bundle.min.js', array( 'jquery'), '1.0.0', true );

    }
}

function my_scripts() {

    wp_enqueue_script(
        'main_js',
        get_template_directory_uri().'/js/main.js',
        array( 'jquery'),
        '1.0.0',
        true
    );

    wp_localize_script(
        'main_js',
        'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );

}
add_action( 'wp_enqueue_scripts', 'my_scripts' );


// Додаткові налаштування теми
add_action('after_setup_theme', 'theme_setup');

function theme_setup() {
    // Активація можливості додавання Мініатюри/Головного зображення до записів
    add_theme_support('post-thumbnails');

    add_theme_support('title-tag');

}


// Створення кастомного типу запису
add_action( 'init', 'register_post_types' );

function register_post_types(){
    // Реєстрація кастомного типу запису "slider" і його параметрів
    register_post_type( 'slider', [
        'label'  => null,
        'labels' => [
            'name'               => 'Slider',
            'singular_name'      => 'Slide',
            'add_new'            => 'Add Slide',
            'add_new_item'       => 'Adding Slide',
            'edit_item'          => 'Editing Slide',
            'new_item'           => 'New Slide',
            'view_item'          => 'View Slide',
            'search_items'       => 'Search Slide',
            'not_found'          => 'Not found',
            'not_found_in_trash' => 'Not found in Trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Slider',
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 4,
        'hierarchical'        => false,
        'supports'            => ['title', 'page-attributes', 'thumbnail'],
        'taxonomies'          => [],
        'has_archive'         => true,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

}


// Створення кастомних мета полів для типу записів Slider
add_action( 'add_meta_boxes', 'slider_custom_fields', 1 );

function slider_custom_fields() {
    $post_type = 'slider';
    add_meta_box( 'Desc', 'Опис', 'slider_custom_fields_func', $post_type, 'normal', 'high' );
}

function slider_custom_fields_func( $post, $args ) {
    ?>
    <p>
        <textarea type="text" name="slide[description]"
                  style="width:100%; height:100px;"><?= get_post_meta( $post->ID, 'description', 1 ) ?></textarea>
    </p>

    <input type="hidden" name="slider_custom_fields_nonce" value="<?= wp_create_nonce( 'slider_custom_fields_nonce_id' ) ?>"/>
    <?php
}


// Зберігання та оновлення мета полів
add_action( 'save_post', 'slider_custom_fields_save_on_update', 0 );

function slider_custom_fields_save_on_update( $post_id ) {
    // Стандартна перевірка
    if(
        empty( $_POST['slide'] )
        || ! wp_verify_nonce( $_POST['slider_custom_fields_nonce'], 'slider_custom_fields_nonce_id' )
        || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id )
    ) {
        return false;
    }

    $slide = $_POST['slide'];

    // Очищення даних
    $slide = array_map( 'sanitize_text_field', $slide );
    foreach( $slide as $key => $value ){
        // Видаляємо поле, якщо воно пусте
        if( ! $value ){
            delete_post_meta( $post_id, $key );
        }
        // Інакше оновлюємо дані поля
        else {
            update_post_meta( $post_id, $key, $value );
        }
    }

    return $post_id;
}


// Ajax запит
//Хук для Ajax запиту авторизованих користувачів
add_action('wp_ajax_show_slide_desc', 'show_slide_desc_callback');
//Хук для Ajax запиту неавторизованих користувачів
add_action ('wp_ajax_nopriv_show_slide_desc', 'show_slide_desc_callback');

function show_slide_desc_callback() {
    // Отримання id поста за допомогою методу GET
    $current_slide_id = $_GET['slide_id'];

    // Перевірка валідності id
    if(isset($slide_id)) {
        // Заповнення аргументів для запиту
        $args = array(
            'post_type' => 'slider',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order_by' => 'ID'
        );

        $query = new WP_Query( $args );
    }

    if ($query->have_posts()) { ?>
        <div class="card_desc_wrapper">
            <div class="description-article">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php
                    $slide_id = get_the_ID();
                    $description = get_post_meta($slide_id, 'description', true);
                    ?>

                    <?php if ($current_slide_id == $slide_id) {
                        echo mb_strimwidth($description, 0, 230, "...");
                    }; ?>

                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    <?php };die;
}