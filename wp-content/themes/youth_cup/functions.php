<?php
# LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );


# CUSTOMIZE THE WORDPRESS ADMIN (off by default)
# require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  #Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  # let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  # USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  #require_once( 'library/custom-post-type.php' );

  # pal form de regiastro
  require_once( 'library/registro.php' );

  # pa ver los regisytrados
  require_once( 'library/members.php' );

  # pa ver los newsletterados
  require_once( 'library/news.php' );

  # launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  # A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  # remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  # remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  # clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  # clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  # enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  # ie conditional wrapper

  # launching this stuff after theme setup
  bones_theme_support();

  # adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  # cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  # cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

# let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

# Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 420, 280, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-420' => __('420px by 280px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http:#code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http:#natko.com/changing-default-wordpress-theme-customization-api-sections/
  http:#code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  # $wp_customize calls go here.
  #
  # Uncomment the below lines to remove the default customize sections

  # $wp_customize->remove_section('title_tagline');
   $wp_customize->remove_section('colors');
   $wp_customize->remove_section('background_image');
  # $wp_customize->remove_section('static_front_page');
  # $wp_customize->remove_section('nav');

  # Uncomment the below lines to remove the default controls
  # $wp_customize->remove_control('blogdescription');

  # Uncomment the following to change the default section titles
  # $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  # $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

# Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} # don't remove this bracket!


/************* COMMENT LAYOUT *********************/

# Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php # custom gravatar call ?>
        <?php
          # create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http:#www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php # end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php # </li> is added by WordPress automatically ?>

<?php
} # don't remove this bracket!

/************* quit read more  *********************/
function new_excerpt_more($more) {
  global $post;
  remove_filter('excerpt_more', 'new_excerpt_more');
  return '';
}
add_filter('excerpt_more','new_excerpt_more',11);



/*************  login directo a los playres  *********************/
function my_custom_login_redirect(){


  $user = wp_get_current_user();

  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
      if ( in_array('subscriber', $user->roles) ) {

          wp_redirect( get_permalink('page_id=277') );
          die;
      }
  }



  wp_redirect( home_url("?page_id=277") );

  exit();
}
add_action( 'wp_login','my_custom_login_redirect' );

function my_custom_logout_redirect(){
  wp_redirect( home_url() );
  exit();
}
add_action( 'wp_logout', 'my_custom_logout_redirect' );

// Añadir permisos de lectura a páginas y entradas privadas para cualquier usuario con rol suscriptor.

function wp_acceso_contenido_privado(){
global $wp_roles;
// Obtenemos en una variable el rol suscriptor.
$role = get_role('subscriber');
// Le añadimos el permiso de lectura a páginas privadas.
$role->add_cap('read_private_pages');
// Incluimos también el permiso de lectura a posts privados.
$role->add_cap('read_private_posts');
}

// Llamada a nuestra función.
add_action ( 'admin_init', 'wp_acceso_contenido_privado' );


function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/library/images/login-logo.png);
			height:48px;
			width:334px;
			background-size: 334px 48px;
			background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_filter( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url($url) {
    return home_url();
}


function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/library/css/style-login.css' );
    wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/library/js/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

?>
