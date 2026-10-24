<?php
/** Main fallback template. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="section page-template"><div class="section-inner">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'entry-content' ); ?>><div class="section-kicker"><?php echo esc_html( get_the_date() ); ?></div><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php the_excerpt(); ?><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continue reading', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a></article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1><?php esc_html_e( 'Nothing found', 'fidel-projects' ); ?></h1>
	<?php endif; ?>
</div></main>
<?php get_footer(); ?>
