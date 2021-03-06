<?php
// Функция для работы с визуалом сайта
if (! function_exists('auto_park_setup'))  {
	function auto_park_setup() {
		// Возможность добавления логотипа
		add_theme_support('custom-logo', [
			'height'      => 50,
			'width'       => 130,
			'flex-width'  => false,
			'flex-height' => false,
			'header-text' => '',
			'unlink-homepage-logo' => false, 
		]);
		// Подключаем поддержку HTML5 тегов
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'script',
			'style',
		) );
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
	wp_enqueue_script( 'contact-js', get_template_directory_uri() . '/plugins/form/contact.js', array('jquery'), '1.0.0', true );
    //Подключение custom-js
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true );
}

// Регистрация нескольких областей меню
function auto_park_menus() {
	// Собираем несколько областей меню
	$locations = array(
		'header'  => __( 'Header_menu', 'auto_park' ),
		'footer_left' => __( 'Footer Left menu', 'auto_park' ),
		'footer_right' => __( 'Footer Right menu', 'auto_park' ),
		
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
	register_sidebar( array( 

	'name'          => esc_html( 'Сайдбар подвала', 'auto_park' ),
	'id'            => "sidebar-footer-text",
	'before_widget' => '<div class="footer-widget footer-link %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>'    
	) );
	register_sidebar( array( 

	'name'          => esc_html( 'Контакты подвала', 'auto_park' ),
	'id'            => "sidebar-footer-contacts",
	'before_widget' => '<div class="footer-widget footer-text %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>'    
	) );
}




/**
 * Добавление нового виджета Download_widget.
 */
class Download_widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'download_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: download_widget
			'Полезные файлы',
			array( 'description' => 'Прикрепите ссылки на полезные файлы', 'classname' => 'download',)
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_download_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_download_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
        $file_name = $instance['file_name'];
        $file = $instance['file'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<a href = "'.$file.'"><i class="fa fa-file-pdf"></i>'.$file_name.'</a>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Полезные файлы';
        $file_name = @ $instance['file_name'] ?: 'Название файла';
        $file = @ $instance['file'] ?: 'URL файла';
        
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'file_name' ); ?>"><?php _e( 'Название файла' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'file_name' ); ?>" name="<?php echo $this->get_field_name( 'file_name' ); ?>" type="text" value="<?php echo esc_attr( $file_name ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'file' ); ?>"><?php _e( 'Ссылка на файл' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'file' ); ?>" name="<?php echo $this->get_field_name( 'file' ); ?>" type="text" value="<?php echo esc_attr( $file ); ?>">
		</p>
        
		<?php
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['file_name'] = ( ! empty( $new_instance['file_name'] ) ) ? strip_tags( $new_instance['file_name'] ) : '';
        $instance['file'] = ( ! empty( $new_instance['file'] ) ) ? strip_tags( $new_instance['file'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_download_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_download_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_template_directory_uri();

		wp_enqueue_script('download_widget_script', $theme_url .'/js/download_widget_script.js' );
	}

	// стили виджета
	function add_download_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_download_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.download_widget a{ display:inline; }
		</style>
		<?php
	}

}
// конец класса Download_widget

// регистрация Download_widget в WordPress
function register_download_widget() {
	register_widget( 'Download_widget' );
}
add_action( 'widgets_init', 'register_download_widget' );


// Шаблон комментов 


class Bootstrap_Walker_Comment extends Walker {


	public $db_fields = array(
		'parent' => 'comment_parent',
		'id'     => 'comment_ID',
	);




	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children">' . "\n";
				break;
		}
	}


	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= "</ol><!-- .children -->\n";
				break;
			case 'ul':
			default:
				$output .= "</ul><!-- .children -->\n";
				break;
		}
	}


	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

	
		if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
			foreach ( $children_elements[ $id ] as $child ) {
				$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
			}

			unset( $children_elements[ $id ] );
		}

	}


	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$comment = $data_object;

		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( 'comment' === $comment->comment_type ) {
			add_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 );
		}

		if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}

		if ( 'comment' === $comment->comment_type ) {
			remove_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40 );
		}
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func(
				$args['end-callback'],
				$data_object, // The current comment object.
				$args,
				$depth
			);
			$output .= ob_get_clean();
			return;
		}
		if ( 'div' === $args['style'] ) {
			$output .= "</div><!-- #comment-## -->\n";
		} else {
			$output .= "</li><!-- #comment-## -->\n";
		}
	}

	
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		<?php
	}

	
	public function filter_comment_text( $comment_text, $comment ) {
		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $comment && '0' == $comment->comment_approved && ! $show_pending_links ) {
			$comment_text = wp_kses( $comment_text, array() );
		}

		return $comment_text;
	}

	
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		$commenter          = wp_get_current_commenter();
		$show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.' );
		}
		?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' !== $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if ( 0 != $args['avatar_size'] ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
			<?php
			$comment_author = get_comment_author_link( $comment );

			if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
				$comment_author = get_comment_author( $comment );
			}

			printf(
				/* translators: %s: Comment author link. */
				__( '%s <span class="says">says:</span>' ),
				sprintf( '<cite class="fn">%s</cite>', $comment_author )
			);
			?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
			<?php
			printf(
				'<a href="%s">%s</a>',
				esc_url( get_comment_link( $comment, $args ) ),
				sprintf(
					/* translators: 1: Comment date, 2: Comment time. */
					__( '%1$s at %2$s' ),
					get_comment_date( '', $comment ),
					get_comment_time()
				)
			);

			edit_comment_link( __( '(Edit)' ), ' &nbsp;&nbsp;', '' );
			?>
		</div>

		<?php
		comment_text(
			$comment,
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				)
			)
		);
		?>

		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				)
			)
		);
		?>

		<?php if ( 'div' !== $args['style'] ) : ?>
		</div>
		<?php endif; ?>
		<?php
	}

	
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Ваш коментарии ожидает модерации' );
		} else {
			$moderation_note = __( 'Ваш коментарии ожидает модерации.  Ваш коментарии будет опубликован после проверки' );
		}
		?>

		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="media mb-4">
			<?php
				if ( 0 != $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'], 'mystery','', array('class' => 'img-fluid d-flex mr-4 rounded') );
				}
				?>

				<footer>					
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						__( '%s ' ),sprintf( '<h5>%s</h5>', $comment_author )
					);
					?>


					<div class="comment-metadata">
						<?php
						printf(
							'<a href="%s" class="text-muted"><time datetime="%s">%s</time></a>',
							esc_url( get_comment_link( $comment, $args ) ),
							get_comment_time( 'c' ),
							sprintf(
								/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s' ),
								get_comment_date( 'j F Y', $comment ),
								get_comment_time()
							)
						);

						edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
					<?php endif; ?>
				<div class="mt-2">
					<?php comment_text(); ?>
					</div><!-- .mt-2 -->
				
					<?php
				if ( '1' == $comment->comment_approved || $show_pending_links ) {
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="reply">',
								'after'     => '</div>',
							)
						)
					);
				}
				?>
				</footer><!-- .comment-meta -->
			</article><!-- .comment-body -->
		<?php
	}
}

//Регистрация тип записи услуги 

add_action('init', 'my_custom_init');
function my_custom_init(){
	register_post_type('service', array(
		'labels'             => array(
			'name'               => 'Услуги', // Основное название типа записи
			'singular_name'      => 'Услуга', // отдельное название записи типа service
			'add_new'            => 'Добавить новую',
			'add_new_item'       => 'Добавить новую услугу',
			'edit_item'          => 'Редактировать услугу',
			'new_item'           => 'Новая услуга',
			'view_item'          => 'Посмотреть услугу',
			'search_items'       => 'Найти услугу',
			'not_found'          => 'услуг не найдено',
			'not_found_in_trash' => 'В корзине услуг не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'услуги'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'			 => 'dashicons-format-aside',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
	) );

//Регистрация тип записи цены 
	register_post_type('price', array(
		'labels'             => array(
			'name'               => 'Цены', // Основное название типа записи
			'singular_name'      => 'Цена', // отдельное название записи типа service
			'add_new'            => 'Добавить новую',
			'add_new_item'       => 'Добавить новую Цену',
			'edit_item'          => 'Редактировать Цену',
			'new_item'           => 'Новая Цена',
			'view_item'          => 'Посмотреть Цену',
			'search_items'       => 'Найти Цену',
			'not_found'          => 'Цен не найдено',
			'not_found_in_trash' => 'В корзине Цен не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Цена'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'			 => 'dashicons-money-alt',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments', 'custom-fields')
	) );


//Регистрация тип записи клиенты
	register_post_type('testimonial', array(
		'labels'             => array(
			'name'               => 'Отзыв', // Основное название типа записи
			'singular_name'      => 'Отзывы', // отдельное название записи типа service
			'add_new'            => 'Добавить Отзыв',
			'add_new_item'       => 'Добавить новый Отзыв',
			'edit_item'          => 'Редактировать Отзыв',
			'new_item'           => 'Новая Отзыв',
			'view_item'          => 'Посмотреть Отзыв',
			'search_items'       => 'Найти Отзыв',
			'not_found'          => 'Отзыв не найдено',
			'not_found_in_trash' => 'В корзине Отзыв не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Отзыв'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'			 => 'dashicons-format-status',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array('title','thumbnail','excerpt','custom-fields')
	) );
}

add_action('wp_ajax_my_action', 'my_action_callback');
add_action('wp_ajax_nopriv_my_action', 'my_action_callback');


function my_action_callback() {
	echo 'Обработка формы';
	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}


