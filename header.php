<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Recruitment_WP
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
			wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<main>
		<header class="header-main">
			<div class="container">
				<div class="header-main__content">
					<div class="header-main--left">
						<?php the_custom_logo();?>
					</div>
					<div class="header-main--right">
						<nav class="nav-main">
							<?php wp_nav_menu(array(
				                  'theme_location' => 'top',
				                  'menu_class' => 'menu-main',
				              )); ?>
						</nav>
					</div>
				</div>
			</div>
		</header>