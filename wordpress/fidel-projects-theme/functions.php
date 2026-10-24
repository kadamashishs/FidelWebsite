<?php
/**
 * Theme setup and shared functionality.
 *
 * @package Fidel_Projects
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fidel_projects_setup() {
	load_theme_textdomain( 'fidel-projects', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/site.css' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 200,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'custom-header',
		array(
			'width'         => 1920,
			'height'        => 900,
			'flex-width'    => true,
			'flex-height'   => true,
			'header-text'   => false,
			'uploads'       => true,
		)
	);
	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'fidel-projects' ),
			'footer'  => __( 'Footer Navigation', 'fidel-projects' ),
		)
	);
}
add_action( 'after_setup_theme', 'fidel_projects_setup' );

function fidel_projects_fallback_menu() {
	echo '<ul id="primary-menu" class="nav-links">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'fidel-projects' ) . '</a></li>';
	wp_list_pages( array( 'title_li' => '', 'depth' => 1 ) );
	echo '</ul>';
}

function fidel_projects_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'fidel-projects-style', get_template_directory_uri() . '/assets/css/site.css', array(), $theme_version );
	wp_enqueue_script( 'fidel-projects-script', get_template_directory_uri() . '/assets/js/site.js', array(), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'fidel_projects_assets' );

function fidel_projects_register_content() {
	$labels = array(
		'name'          => __( 'Projects', 'fidel-projects' ),
		'singular_name' => __( 'Project', 'fidel-projects' ),
		'add_new_item'  => __( 'Add New Project', 'fidel-projects' ),
		'edit_item'     => __( 'Edit Project', 'fidel-projects' ),
	);
	register_post_type(
		'fidel_project',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'projects' ),
			'menu_icon'    => 'dashicons-hammer',
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'fidel_service',
		array(
			'labels'       => array(
				'name'          => __( 'Services', 'fidel-projects' ),
				'singular_name' => __( 'Service', 'fidel-projects' ),
				'add_new_item'  => __( 'Add New Service', 'fidel-projects' ),
				'edit_item'     => __( 'Edit Service', 'fidel-projects' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'capabilities' ),
			'menu_icon'    => 'dashicons-admin-tools',
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'fidel_projects_register_content' );

function fidel_projects_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'fidel_projects_contact',
		array(
			'title'    => __( 'Fidel Contact Details', 'fidel-projects' ),
			'priority' => 35,
		)
	);

	$settings = array(
		'fidel_projects_phone' => array( __( 'Phone number', 'fidel-projects' ), '' ),
		'fidel_projects_email' => array( __( 'Enquiry email', 'fidel-projects' ), get_option( 'admin_email' ) ),
		'fidel_projects_linkedin' => array( __( 'LinkedIn URL', 'fidel-projects' ), 'https://www.linkedin.com/company/fidel-engineering-works/' ),
	);

	foreach ( $settings as $setting_id => $setting_values ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $setting_values[1],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $setting_values[0],
				'section' => 'fidel_projects_contact',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'fidel_projects_customize_register' );

function fidel_projects_handle_contact() {
	if ( ! isset( $_POST['fidel_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fidel_contact_nonce'] ) ), 'fidel_contact' ) ) {
		wp_die( esc_html__( 'The form could not be verified. Please go back and try again.', 'fidel-projects' ) );
	}

	$name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone        = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$project_type = isset( $_POST['project_type'] ) ? sanitize_text_field( wp_unslash( $_POST['project_type'] ) ) : '';
	$timeline     = isset( $_POST['timeline'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline'] ) ) : '';
	$message      = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( empty( $name ) || ! is_email( $email ) || empty( $message ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) );
		exit;
	}

	$recipient = sanitize_email( get_theme_mod( 'fidel_projects_email', get_option( 'admin_email' ) ) );
	$subject   = sprintf( __( 'Website enquiry: %s', 'fidel-projects' ), $project_type ? $project_type : __( 'New project', 'fidel-projects' ) );
	$body      = implode(
		"\n",
		array(
			sprintf( __( 'Name: %s', 'fidel-projects' ), $name ),
			sprintf( __( 'Email: %s', 'fidel-projects' ), $email ),
			sprintf( __( 'Phone: %s', 'fidel-projects' ), $phone ? $phone : __( 'Not provided', 'fidel-projects' ) ),
			sprintf( __( 'Project type: %s', 'fidel-projects' ), $project_type ? $project_type : __( 'Not specified', 'fidel-projects' ) ),
			sprintf( __( 'Timeline: %s', 'fidel-projects' ), $timeline ? $timeline : __( 'Not specified', 'fidel-projects' ) ),
			'',
			$message,
		)
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = $recipient && wp_mail( $recipient, $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'failed', wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fidel_contact', 'fidel_projects_handle_contact' );
add_action( 'admin_post_fidel_contact', 'fidel_projects_handle_contact' );

function fidel_projects_contact_notice() {
	if ( empty( $_GET['contact'] ) ) {
		return;
	}
	$status  = sanitize_key( wp_unslash( $_GET['contact'] ) );
	$notices = array(
		'sent'    => __( 'Thank you. Your enquiry has been sent.', 'fidel-projects' ),
		'invalid' => __( 'Please check the required fields and try again.', 'fidel-projects' ),
		'failed'  => __( 'Your message could not be sent right now. Please contact us by email.', 'fidel-projects' ),
	);
	if ( isset( $notices[ $status ] ) ) {
		echo '<p class="contact-result" role="status">' . esc_html( $notices[ $status ] ) . '</p>';
	}
}

function fidel_projects_asset( $filename ) {
	return get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' );
}
