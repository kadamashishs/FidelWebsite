<?php
/** Default page template. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="section page-template"><div class="section-inner">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="section-kicker"><?php esc_html_e( 'Fidel Projects', 'fidel-projects' ); ?></div>
		<h1><?php the_title(); ?></h1>
		<div class="entry-content"><?php the_content(); ?></div>
	<?php endwhile; ?>
</div></main>
<?php get_footer(); ?>
