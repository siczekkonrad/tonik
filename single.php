<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Recruitment_WP
 */

get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section id="content">
	<div class="container">
		
		<div class="entry-content">
			<h1><?php the_title();?></h1>
			<?php the_content();?>

			
			<div class="entry-tags">
				<?php the_tags(" ", " ", " "); ?>
			</div>

			<div class="entry-author__info">
				 <span class="author__image"><?php echo get_avatar($post->ID); ?> </span>
				 <span class="author__name">
				 	<?php

						$fname = get_the_author_meta('first_name');
						$lname = get_the_author_meta('last_name');
						$full_name = '';

						if( empty($fname)){
						    $full_name = $lname;
						} elseif( empty( $lname )){
						    $full_name = $fname;
						} else {
						    //both first name and last name are present
						    $full_name = "{$fname} {$lname}";
						}

						echo $full_name;
					?>
				 </span>
				 
					<span class="auhtor__description"><?php the_author_meta('description');?></span>
			</div>
			
		</div>

	</div>
</section>
<?php endwhile; endif; ?>










<?php get_footer();?>