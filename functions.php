<?php
// Функция для работы с визуалом сайта
if (! function_exists('auto_park_setup'))  {
	function auto_park_setup() {
		// Добовляем пользовательское лого
		add_theme_support('custom-logo', [
			'height'      => 50,
			'width'       => 130,
			'flex-width'  => false,
			'flex-height' => false,
			'header-text' => '',
			'unlink-homepage-logo' => false, 
		]);
		// Добавляем динамический <title>
		add_theme_support('title-tag');
        // Включаем миниатюры для постов и страниц	
        add_theme_support( 'post-thumbnails'); 
        set_post_thumbnail( 730, 480, true );   //размер миниатюры поста
	}

 

     
	add_action('after_setup_theme', 'auto_park_setup');  
    
}

//Подключение стилей
add_action( 'wp_enqueue_scripts', 'Auto_park_scripts' );


function Auto_park_scripts() {
	wp_enqueue_style( 'main', get_stylesheet_uri() );
    // Подключение Bootstrap
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/css/bootstrap.css' , array('main'));
    // Подключение Шрифтов
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/plugins/fontawesome/css/all.css' , array('main'));
    // Подключение анимации css
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/plugins/animate-css/animate.css' , array('main'));
    // Подключение шрифтов иконок
    wp_enqueue_style( 'icofont', get_template_directory_uri() . '/plugins/icofont/icofont.css' , array('main'));

    wp_enqueue_style( 'Auto_park', get_template_directory_uri() . '/css/style.css' , array('bootstrap'));

    //Переподключаем jquery и другие фреймворки
    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/plugins/jquery/jquery.min.js');
	wp_enqueue_script( 'jquery');
    //Подключение popper
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/plugins/bootstrap/js/popper.min.js', array('jquery'), '1.0.0', true );
    //Подключение bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.min.js', array('jquery'), '1.0.0', true );
    //Подключение wow
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/plugins/counterup/wow.min.js', array('jquery'), '1.0.0', true );
    //Подключение jqueryeasing
	wp_enqueue_script( 'jqueryeasing', get_template_directory_uri() . '/plugins/counterup/jquery.easing.1.3.js', array('jquery'), '1.0.0', true );
    //Подключение waypoints
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/plugins/counterup/jquery.waypoints.js', array('jquery'), '1.0.0', true );
    //Подключение counterup
	wp_enqueue_script( 'counterup', get_template_directory_uri() . '/plugins/counterup/jquery.counterup.min.js', array('jquery'), '1.0.0', true );
    //Подключение карты googlemap
	wp_enqueue_script( 'googlemap', get_template_directory_uri() . '/plugins/google-map/gmap3.min.js', array('jquery'), '1.0.0', true );
    //Подключение contacs-js
	wp_enqueue_script( 'contact-js', get_template_directory_uri() . '/plugins/jquery/contact.js', array('jquery'), '1.0.0', true );
    //Подключение custom-js
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true );
}

// Регистрация нескольких областей меню
function auto_park_menus() {
	// Собираем несколько областей меню
	$locations = array(
		'header'  => __( 'Header_menu', 'auto_park' ),
		'footer' => __( 'Footer_menu', 'auto_park' ),
		
	);
	//Регистрируем области меню, которые лежат в переменной $locations
	register_nav_menus( $locations );
    
}


//хук-событие 
add_action( 'init', 'auto_park_menus' );



// Меню сайти с выпадающим меню через Bootstrap 4
class bootstrap_4_walker_nav_menu extends Walker_Nav_menu {
    
    function start_lvl( &$output, $depth = 0, $args = array() ){ // ul
        $indent = str_repeat("\t",$depth); // indents the outputted HTML
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }
  
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span
        
    $indent = ( $depth ) ? str_repeat("\t",$depth) : '';
    
    $li_attributes = '';
        $class_names = $value = '';
    
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if( $depth && $args->walker->has_children ){
            $classes[] = 'dropdown-menu';
        }
        
        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
        
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';
        
        $item_output = $args->before;
        $item_output .= ( $depth > 0 ) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    
    }
    
}



## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// Удаляем H2 из шаблона пагинации
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
	return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>
	';
}

// Вывод пагинации на сайте
the_posts_pagination( array(
	'end_size' => 2,
) );

//Сайдбар меню на странице "Журнал"
add_action('widgets_init','auto_park_widgets_init');
function auto_park_widgets_init(){
register_sidebar( array( 

    'name'          => esc_html( 'Сайдбар блога', 'auto_park' ),
	'id'            => "sidebar-blog",
	'before_widget' => '<section id="%1$s" class="sidebar-widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h5 class="widget-title mb-3">',
	'after_title'   => '</h5>'    
    ) );
}

