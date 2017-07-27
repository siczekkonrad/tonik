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
		<div class="entry-column">
			<div class="entry-content">
				<h1><?php the_title();?></h1>

					<?php if(has_excerpt( $post->ID )):?>
						<!-- if has excerpt -->
							<div class="entry-content__excerpt">
								<?php the_excerpt();?>
							</div>
						<!-- exceprt end -->
					<?php endif;?>
			
			</div>

			
				<?php if(has_post_thumbnail()):?>
					<!-- if has thumbnail -->
						<div class="entry-content__featured">
							<?php $featured_img_url = get_the_post_thumbnail_url($post->ID); ?>

							<div class="entry__featured" style="background-image: url(<?php echo $featured_img_url;?>);"></div>
						</div>
					<!-- thumbnail end -->
				<?php endif;?>
			

			<div class="entry-content">
			
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
	</div>
</section>
<?php endwhile; endif; ?>










<?php get_footer();?>