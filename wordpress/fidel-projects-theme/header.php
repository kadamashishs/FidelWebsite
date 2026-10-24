<?php
/** Theme header. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'fidel-projects' ); ?>">
		<div class="brand-lockup">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="logo-mark" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="logo-image" src="<?php echo esc_url( fidel_projects_asset( 'Logo.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
			<?php endif; ?>
			<a class="logo-name" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</div>
		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="<?php esc_attr_e( 'Open navigation menu', 'fidel-projects' ); ?>"><span></span><span></span><span></span></button>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'nav-links',
				'fallback_cb'    => 'fidel_projects_fallback_menu',
			)
		);
		?>
	</nav>
</header>
