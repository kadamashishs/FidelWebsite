<?php
/** Not-found template. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="section page-template"><div class="section-inner"><div class="section-kicker">404</div><h1><?php esc_html_e( 'Page not found', 'fidel-projects' ); ?></h1><p><?php esc_html_e( 'The page you requested is unavailable. Return to the homepage to explore Fidel Projects.', 'fidel-projects' ); ?></p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return home', 'fidel-projects' ); ?></a></div></main>
<?php get_footer(); ?>
