<?php
/**
 * Recruitment WP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Recruitment_WP
 */

if( ! function_exists('basic_setup')) :

	function basic_setup() {

		add_theme_support( 'post-thumbnails' ); 

		register_nav_menus(
			array(
			  'top' => __( 'Top Menu' )
			)
		);

	}
endif;

add_action( 'init', 'basic_setup' );
add_theme_support( 'custom-logo',array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
) );


if ( ! function_exists( 'recruitment_wp_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function recruitment_wp_setup() {
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );
	}
endif;
add_action( 'after_setup_theme', 'recruitment_wp_setup' );

function tonik_theme_styles(){

	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/public/css/theme.css', array());

}

add_action('wp_enqueue_scripts', 'tonik_theme_styles');



if(function_exists('register_sidebar') ){
            register_sidebar( array(
                'name'          => 'Footer - Column 1',
                'id'            => 'footer_column1',
                'before_widget' => '<div class="footer-column">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="footer-title">',
                'after_title'   => '</h4>'
            ));
            register_sidebar( array(
                'name'          => 'Footer - Column 2',
                'id'            => 'footer_column2',
                'before_widget' => '<div class="footer-column">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="footer-title">',
                'after_title'   => '</h4>'
            ));
            register_sidebar( array(
                'name'          => 'Footer - Column 3',
                'id'            => 'footer_column3',
                'before_widget' => '<div class="footer-column">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="footer-title">',
                'after_title'   => '</h4>'
            ));

        }


add_filter( 'manage_posts_columns', 'revealid_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'revealid_id_column_content', 5, 2 );


function revealid_add_id_column( $columns ) {
   $columns['revealid_id'] = 'ID';
   return $columns;
}

function revealid_id_column_content( $column, $id ) {
  if( 'revealid_id' == $column ) {
    echo $id;
  }
}



 function add_banners() {
        $labels = array(
            'name' => _x('Banners', 'post type general name'),
            'singular_name' => _x('Banner', 'post type singular name'),
            'add_new' => _x('Add New', 'Banner'),
            'add_new_item' => __('Add New Banner'),
            'edit_item' => __('Edit Banner'),
            'new_item' => __('New Banner'),
            'view_item' => __('View Banner'),
            'search_items' => __('Search Banner'),
            'not_found' =>  __('Nothing found'),
            'not_found_in_trash' => __('Nothing found in Trash'),
            'parent_item_colon' => ''
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => null,
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'register_meta_box_cb' => 'banner_link_meta_box',
            'supports' => array('title', 'page-attributes','post-formats', 'excerpt', 'thumbnail'),
            'taxonomies' => array('category_banners') 
        ); 
        register_post_type( 'banner' , $args );
        register_taxonomy("categories", array("banner"), array("hierarchical" => true, "label" => "Categories", "singular_label" => "Category", "rewrite" => array( 'slug' => 'banner', 'with_front'=> false )));

        }

    add_action('init', 'add_banners');




/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function nw_add_custom_meta_box() {

    $screens = array( 'site' ); // add items to add to multiple post types

    foreach ( $screens as $screen ) {
        add_meta_box(
        'website', // $id
        'Website', // $title 
        'show_custom_meta_box', // $callback
        $screen, // $page
        'normal', // $context
        'high' // $priority
        );
    }
}

function banner_link_meta_box() {

    add_meta_box(
        'banner-link',
        __( 'Banner Link', 'tonikt' ),
        'banner_link_meta_box_callback',
        'banner'
    );
}

add_action( 'add_meta_boxes', 'banner_link_meta_box' );


function banner_link_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'banner_link_nonce', 'banner_link_nonce' );

    $value = get_post_meta( $post->ID, '_banner_link', true );

    echo '<textarea style="width:100%"  name="banner_link">' . esc_attr( $value ) . '</textarea>';
}


function save_banner_link_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['banner_link_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['banner_link_nonce'], 'banner_link_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['banner_link'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['banner_link'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_banner_link', $my_data );
}

add_action( 'save_post', 'save_banner_link_meta_box_data' );



add_shortcode( 'display_banner', 'display_banner_post_type' );

    function display_banner_post_type($atts){
    	global $post;

        $default = array(
            'post_type' => 'banner',
            'p'=> '',
            'category_name'=> ''
        );

        $r = shortcode_atts( $default, $atts);
        extract( $r );

        $string = '';
        $query = new WP_Query( $r );
        if( $query->have_posts() ){
        	$string .= '<div class="banner">';
            while( $query->have_posts() ){
                $query->the_post();
                if($r['category_name'] == 'download') {
                	$icon = 'download';
                }elseif($r['category_name'] == 'information'){
                	$icon = 'settings';
                }
                $string .=  '<div class="banner__wrapper">';
                $string .=  '<div class="banner__icon">';
                $string .=  '<img src="'. get_template_directory_uri() .'/assets/icon-'. $icon .'.svg"/>';
                $string .=  '</div>';
                $string .=  '<div class="banner__content">';
                $string .=  '<a class="banner__title" href="' . get_post_meta( $post->ID, '_banner_link', true ) . '"> '.get_the_title(). '</a>';
                $string .=  '<span class="banner__text">' . get_the_excerpt() . '</span>' ;
                
                $string .=  '</div>';    
            }
            $string .= '</div>';
            wp_reset_postdata();
        }
        return $string;
        wp_reset_query();
    }


/// options
    function theme_settings_page(){
	    ?>
		    <div class="wrap">
		    <h1>Social Media</h1>
		    <form method="post" action="options.php">
		        <?php
		            settings_fields("section");
		            do_settings_sections("theme-options");      
		            submit_button(); 
		        ?>          
		    </form>
			</div>
		<?php
	}
function add_theme_menu_item(){
	add_menu_page("Social Media", "Social Media", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

    function display_twitter_element(){
	?>
		<input type="checkbox" name="twitter" value="1" <?php checked(1, get_option('twitter'), true); ?> /> 
	<?php
	}

	function display_facebook_element(){
	?>
		<input type="checkbox" name="facebook" value="1" <?php checked(2, get_option('facebook'), true); ?> /> 
	<?php
	}

	function display_linkedin_element(){
	?>
		<input type="checkbox" name="linkedin" value="1" <?php checked(3, get_option('linkedin'), true); ?> /> 
	<?php
	}
   

   function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("twitter", "Do you want share on Twiiter?", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook", "Do you want share on Facebook?", "display_facebook_element", "theme-options", "section");
    add_settings_field("linkedin", "Do you want share on Linkedin?", "display_linkedin_element", "theme-options", "section");

    register_setting("section", "twitter");
    register_setting("section", "facebook");
    register_setting("section", "linkedin");
}

add_action("admin_init", "display_theme_panel_fields");