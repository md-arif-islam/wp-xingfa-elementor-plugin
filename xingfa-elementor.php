<?php
/*
Plugin Name: Xingfa Elementor Plugin
Plugin URI:
Description:
Version: 1.0
Author: Arif Islam
Author URI: https://arifislam.techviewing.com
License: GPLv2 or later
Text Domain: xingfaelementor
Domain Path: /languages/
*/


use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	die( __( "Direct Access is not allowed", 'xingfaelementor' ) );
}

final class ElementorCustomExtension {

	const VERSION = "1.0.0";
	const MINIMUM_ELEMENTOR_VERSION = "2.0.0";
	const MINIMUM_PHP_VERSION = "7.0";

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		load_plugin_textdomain( 'xingfacustom' );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );

			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );

			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );

			return;
		}

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

//		add_action( "elementor/elements/categories_registered", [ $this, 'register_new_category' ] );
		add_action( "elementor/frontend/after_enqueue_styles", [ $this, 'widget_styles' ] );
		add_action( "elementor/frontend/after_enqueue_scripts", [ $this, 'all_widgets_assets' ] );

	}

	function all_widgets_assets() {
		wp_enqueue_style( 'bootstrap-css', '//cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css' );
		wp_enqueue_style( 'owl-carousel-css', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' );
		wp_enqueue_style( 'owl-carousel-theme-css', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css' );
		wp_enqueue_style( 'custom-elementor-css', plugins_url( "/assets/css/style.css", __FILE__ ) );
		wp_enqueue_script( 'bootstrap-js', "//cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js", [ 'jquery' ], time(), true );
		wp_enqueue_script( 'isotope-js', "//unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js", [ 'jquery' ], time(), true );
		wp_enqueue_script( 'owl-carousel-js', "//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js", [ 'jquery' ], time(), true );
		wp_enqueue_script( 'custom-elementor-js', plugins_url( "/assets/js/app.js", __FILE__ ), [ 'jquery' ], time(), true );

	}


	function widget_styles() {
//		wp_enqueue_style( "froala-css", "//cdnjs.cloudflare.com/ajax/libs/froala-design-blocks/2.0.1/css/froala_blocks.min.css" );
	}


	/*public function register_new_category( $manager ) {
		$manager->add_category( 'testcategory', [
			'title' => __( 'Test Category', 'xingfacustom' ),
			'icon'  => 'fa fa-image'
		] );
	}*/

	public function init_widgets() {
		require_once( __DIR__ . '/widgets/projects.php' );
		require_once( __DIR__ . '/widgets/companyn.php' );
		require_once( __DIR__ . '/widgets/industryn.php' );
		require_once( __DIR__ . '/widgets/career.php' );
		require_once( __DIR__ . '/widgets/product.php' );
		require_once( __DIR__ . '/widgets/all-product.php' );

		// Register widget
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Project_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_CompanyNews_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_IndustryNews_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Career_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Product_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_AllProduct_Widget() );

	}


	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'xingfacustom' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'xingfacustom' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'xingfacustom' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'xingfacustom' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'xingfacustom' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'xingfacustom' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'xingfacustom' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'xingfacustom' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'xingfacustom' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );


	}

	public function includes() {
	}

}

ElementorCustomExtension::instance();

