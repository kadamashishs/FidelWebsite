<?php
/** Single content template. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="section page-template"><div class="section-inner">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="section-kicker"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></div>
		<h1><?php the_title(); ?></h1>
		<?php if ( has_post_thumbnail() ) : ?><div class="single-featured-image"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?>
		<div class="entry-content"><?php the_content(); ?></div>
	<?php endwhile; ?>
</div></main>
<?php get_footer(); ?>
