<?php
/** Theme footer. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<footer class="site-footer">
	<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'fidel-projects' ); ?></p>
	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => 'nav', 'container_aria_label' => __( 'Footer navigation', 'fidel-projects' ), 'menu_class' => 'footer-links' ) ); ?>
	<?php else : ?>
		<?php $linkedin = get_theme_mod( 'fidel_projects_linkedin', 'https://www.linkedin.com/company/fidel-engineering-works/' ); ?>
		<?php if ( $linkedin ) : ?><a class="footer-linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a><?php endif; ?>
	<?php endif; ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
