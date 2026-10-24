<?php
/** Front page template. @package Fidel_Projects */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$hero_image = get_header_image() ? get_header_image() : fidel_projects_asset( 'industry-3.jpeg' );
?>
<main>
	<section class="hero" id="home">
		<div class="hero-copy">
			<p class="eyebrow"><?php esc_html_e( 'Engineering delivery partner', 'fidel-projects' ); ?><span class="eyebrow-rule"></span><?php esc_html_e( 'Process industries', 'fidel-projects' ); ?></p>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="hero-lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			<p class="hero-cta"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start a conversation', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a><a class="btn btn-secondary" href="#services"><?php esc_html_e( 'Explore capabilities', 'fidel-projects' ); ?> <span aria-hidden="true">↓</span></a></p>
		</div>
		<div class="hero-visual"><img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Industrial process piping and plant equipment', 'fidel-projects' ); ?>"><div class="hero-note"><span class="status-dot"></span><strong><?php esc_html_e( 'Built for the worksite', 'fidel-projects' ); ?></strong><small><?php esc_html_e( 'One accountable delivery team', 'fidel-projects' ); ?></small></div></div>
		<div class="hero-metric"><strong>01</strong><span><?php esc_html_e( 'Plan with clarity', 'fidel-projects' ); ?></span></div>
	</section>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( trim( get_the_content() ) ) : ?>
			<section class="section page-content"><div class="section-inner entry-content"><?php the_content(); ?></div></section>
		<?php endif; ?>
	<?php endwhile; endif; ?>

	<section class="section services" id="services"><div class="section-inner">
		<div class="section-heading-row"><div><div class="section-kicker"><?php esc_html_e( 'Capabilities', 'fidel-projects' ); ?></div><h2><?php esc_html_e( 'From first drawing to final handover.', 'fidel-projects' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'fidel_service' ) ); ?>"><?php esc_html_e( 'See all services', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a></div>
		<div class="service-list">
			<?php
			$services = new WP_Query( array( 'post_type' => 'fidel_service', 'posts_per_page' => 3, 'post_status' => 'publish' ) );
			if ( $services->have_posts() ) :
				$number = 0;
				while ( $services->have_posts() ) :
					$services->the_post();
					++$number;
					?>
					<article class="service"><span class="service-number"><?php echo esc_html( sprintf( '%02d', $number ) ); ?></span><?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>" class="service-image-link"><?php the_post_thumbnail( 'medium', array( 'class' => 'service-icon' ) ); ?></a><?php endif; ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( get_the_excerpt() ); ?></p></article>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<article class="service"><span class="service-number">01</span><img class="service-icon" src="<?php echo esc_url( fidel_projects_asset( 'icon-fabrication.svg' ) ); ?>" alt=""><h3><?php esc_html_e( 'Fabrication & installation', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'Precise tanks, piping, and process systems with coordinated site installation.', 'fidel-projects' ); ?></p></article>
				<article class="service"><span class="service-number">02</span><img class="service-icon" src="<?php echo esc_url( fidel_projects_asset( 'icon-project.svg' ) ); ?>" alt=""><h3><?php esc_html_e( 'Turnkey projects', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'End-to-end execution from engineering and procurement through commissioning.', 'fidel-projects' ); ?></p></article>
				<article class="service"><span class="service-number">03</span><img class="service-icon" src="<?php echo esc_url( fidel_projects_asset( 'icon-consulting.svg' ) ); ?>" alt=""><h3><?php esc_html_e( 'Technical consulting', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'Practical process, layout, and operational guidance shaped around your plant.', 'fidel-projects' ); ?></p></article>
			<?php endif; ?>
		</div>
	</div></section>

	<section class="section projects" id="projects"><div class="section-inner">
		<div class="section-heading-row"><div><div class="section-kicker"><?php esc_html_e( 'Selected work', 'fidel-projects' ); ?></div><h2><?php esc_html_e( 'Built around real operating pressure.', 'fidel-projects' ); ?></h2></div><div class="project-carousel-actions"><a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'fidel_project' ) ); ?>"><?php esc_html_e( 'View project stories', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a><div class="carousel-buttons"><button class="carousel-button project-carousel-prev" type="button" aria-label="<?php esc_attr_e( 'Previous project', 'fidel-projects' ); ?>">←</button><button class="carousel-button project-carousel-next" type="button" aria-label="<?php esc_attr_e( 'Next project', 'fidel-projects' ); ?>">→</button></div></div></div>
		<div class="project-carousel" aria-label="<?php esc_attr_e( 'Selected project stories', 'fidel-projects' ); ?>"><div class="project-cards" tabindex="0">
			<?php
			$projects = new WP_Query( array( 'post_type' => 'fidel_project', 'posts_per_page' => 6, 'post_status' => 'publish' ) );
			if ( $projects->have_posts() ) :
				while ( $projects->have_posts() ) :
					$projects->the_post();
					?>
					<article class="project-card"><?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a><?php endif; ?><div><span class="project-tag"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( get_the_excerpt() ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read project', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a></div></article>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<article class="project-card"><img src="<?php echo esc_url( fidel_projects_asset( 'industry-1.jpeg' ) ); ?>" alt="<?php esc_attr_e( 'Process valves and control systems', 'fidel-projects' ); ?>"><div><span class="project-tag"><?php esc_html_e( 'Capacity + hygiene', 'fidel-projects' ); ?></span><h3><?php esc_html_e( 'Dairy plant upgrade', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'Upgraded processing systems while keeping production continuity in view.', 'fidel-projects' ); ?></p></div></article>
				<article class="project-card"><img src="<?php echo esc_url( fidel_projects_asset( 'industry-2.jpeg' ) ); ?>" alt="<?php esc_attr_e( 'Industrial process infrastructure', 'fidel-projects' ); ?>"><div><span class="project-tag"><?php esc_html_e( 'Process integration', 'fidel-projects' ); ?></span><h3><?php esc_html_e( 'Ethanol distillation line', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'A complete package with automation, controls, and safety-led execution.', 'fidel-projects' ); ?></p></div></article>
				<article class="project-card"><img src="<?php echo esc_url( fidel_projects_asset( 'industry-4.jpeg' ) ); ?>" alt="<?php esc_attr_e( 'Stainless process tanks', 'fidel-projects' ); ?>"><div><span class="project-tag"><?php esc_html_e( 'Controlled facility', 'fidel-projects' ); ?></span><h3><?php esc_html_e( 'Pharma process facility', 'fidel-projects' ); ?></h3><p><?php esc_html_e( 'Clean process piping installed for a pharmaceutical production line.', 'fidel-projects' ); ?></p></div></article>
			<?php endif; ?>
		</div></div>
	</div></section>
	<section class="section contact-band"><div class="section-inner contact-band-inner"><div><div class="section-kicker"><?php esc_html_e( 'The next move', 'fidel-projects' ); ?></div><h2><?php esc_html_e( 'Have a plant challenge on the table?', 'fidel-projects' ); ?></h2></div><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Talk to Fidel', 'fidel-projects' ); ?> <span aria-hidden="true">↗</span></a></div></section>
</main>
<?php get_footer(); ?>
