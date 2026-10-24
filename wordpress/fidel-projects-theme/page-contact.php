<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 * @package Fidel_Projects
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$email   = get_theme_mod( 'fidel_projects_email', get_option( 'admin_email' ) );
$phone   = get_theme_mod( 'fidel_projects_phone', '' );
?>
<main class="section contact"><div class="section-inner">
	<a id="contact" class="scroll-anchor" aria-hidden="true"></a>
	<div class="section-kicker"><?php esc_html_e( 'Get in touch', 'fidel-projects' ); ?></div>
	<h1><?php the_title(); ?></h1>
	<?php fidel_projects_contact_notice(); ?>
	<div class="contact-grid">
		<div class="contact-addresses"><article class="company"><h2><?php esc_html_e( 'Start a project conversation', 'fidel-projects' ); ?></h2><p><?php esc_html_e( 'Share your plant challenge and the Fidel team will follow up.', 'fidel-projects' ); ?></p><?php if ( $email ) : ?><p><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></p><?php endif; ?><?php if ( $phone ) : ?><p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p><?php endif; ?></article></div>
		<div class="contact-form-wrap">
			<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="fidel_contact">
				<?php wp_nonce_field( 'fidel_contact', 'fidel_contact_nonce' ); ?>
				<label for="fidel-name"><?php esc_html_e( 'Name', 'fidel-projects' ); ?></label><input id="fidel-name" name="name" type="text" autocomplete="name" required>
				<label for="fidel-email"><?php esc_html_e( 'Email', 'fidel-projects' ); ?></label><input id="fidel-email" name="email" type="email" autocomplete="email" required>
				<label for="fidel-phone"><?php esc_html_e( 'Phone or WhatsApp', 'fidel-projects' ); ?></label><input id="fidel-phone" name="phone" type="tel" autocomplete="tel">
				<label for="fidel-project-type"><?php esc_html_e( 'What do you need help with?', 'fidel-projects' ); ?></label><select id="fidel-project-type" name="project_type"><option value=""><?php esc_html_e( 'Select an option', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Fabrication and installation', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Turnkey project delivery', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Technical consulting', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Site workforce support', 'fidel-projects' ); ?></option></select>
				<label for="fidel-timeline"><?php esc_html_e( 'Target timeline', 'fidel-projects' ); ?></label><select id="fidel-timeline" name="timeline"><option value=""><?php esc_html_e( 'Select an option', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Planning stage', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Within 1 month', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'Within 3 months', 'fidel-projects' ); ?></option><option><?php esc_html_e( 'More than 3 months', 'fidel-projects' ); ?></option></select>
				<label for="fidel-message"><?php esc_html_e( 'Project details', 'fidel-projects' ); ?></label><textarea id="fidel-message" name="message" rows="5" required></textarea>
				<button type="submit"><?php esc_html_e( 'Send enquiry', 'fidel-projects' ); ?></button>
			</form>
		</div>
	</div>
</div></main>
<?php get_footer(); ?>
