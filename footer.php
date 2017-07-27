<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Recruitment_WP
 */
?>
		<footer class="footer">
			<div class="container">
				<div class="container-entry">
					<div class="footer-column__wrapper">

						<?php dynamic_sidebar('footer_column1');?>

						<?php dynamic_sidebar('footer_column2');?>

						<?php dynamic_sidebar('footer_column3');?>
						
					</div>
				</div>
			</div>
		</footer>

		</main>

		<?php
	wp_footer();
?>
	</body>
</html>
