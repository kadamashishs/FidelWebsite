<?php
/** Archive template for projects and services. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$archive_title = post_type_archive_title( '', false );
?>
<main class="section page-template"><div class="section-inner">
	<div class="section-kicker"><?php esc_html_e( 'Fidel Projects', 'fidel-projects' ); ?></div>
	<h1><?php echo esc_html( $archive_title ? $archive_title : __( 'Stories and capabilities', 'fidel-projects' ) ); ?></h1>
	<?php if ( have_posts() ) : ?>
		<div class="project-cards archive-cards">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'project-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a><?php endif; ?>
					<div><span class="project-tag"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a></div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Content is being prepared. Please check back soon.', 'fidel-projects' ); ?></p>
	<?php endif; ?>
</div></main>
<?php get_footer(); ?>
