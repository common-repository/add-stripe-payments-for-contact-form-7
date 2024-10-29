<?php

namespace SP4CF7;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    SP4CF7
 * @subpackage SP4CF7/includes
 * @author     Performa Technologies <developer1@performatechnologies.com>
 */
class Main {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $SP4CF7    The string used to uniquely identify this plugin.
	 */
	protected $sp4cf7;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SP4CF7_VERSION' ) ) {
			$this->version = SP4CF7_VERSION;
		} else {
			$this->version = '1.0';
		}
		$this->sp4cf7 = 'sp4cf7';

		$this->define_constants();
		$this->activate_functions();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->init();
	}

	/**
	 * Defines all constants
	 *
	 * @since 1.0.0
	 */
	private function define_constants() {

		if ( !defined( 'SP4CF7_DIR' ) ) {
			define( 'SP4CF7_DIR', dirname( __FILE__ ) ); // Plugin dir
		}
		if ( !defined( 'SP4CF7_BASENAME' ) ) {
			define( 'SP4CF7_BASENAME', function_exists('plugin_basename') ? plugin_basename(__FILE__) : basename(dirname(__FILE__)) . '/' . basename(__FILE__));
		}
		if ( !defined( 'SP4CF7PMP' ) ) {
			define( 'SP4CF7PMP', 'sp4cf7_' ); // Plugin metabox prefix
		}
		if ( !defined( 'SP4CF7_DOMAIN' ) ) {
			define( 'SP4CF7_DOMAIN', 'sp4cf7' ); // Plugin prefix
		}
		if ( !defined( 'SP4CF7_POST_TYPE' ) ) {
			define( 'SP4CF7_POST_TYPE', 'sp4cf7' ); // Custom Post Type
		}
	}

	private function activate_functions() {

		register_activation_hook(__FILE__, array($this, 'installPlugin'));
		register_deactivation_hook(__FILE__, array($this, 'uninstallPlugin'));
	}

	public function installPlugin() {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		\SP4CF7\Activator::activate();

	}

	public function uninstallPlugin(){
		\SP4CF7\Deactivator::deactivate();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		$this->loader = new \SP4CF7\Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$i18n = new \SP4CF7\I18n();
		$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$sp4cf7 = new \SP4CF7\_Admin\SP4CF7_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $sp4cf7, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $sp4cf7, 'enqueue_scripts' );
		$this->loader->add_action( 'wpcf7_admin_init', $sp4cf7, 'wpcf7_admin_init');

		$this->loader->add_action( 'init', $sp4cf7, 'init' );
		$this->loader->add_action( 'add_meta_boxes', $sp4cf7, 'add_meta_boxes' );

		// Save settings of contact form 7 admin
		$this->loader->add_action( 'wpcf7_save_contact_form', $sp4cf7, 'wpcf7_save_contact_form', 10, 2 );

		$this->loader->add_action( 'manage_'.SP4CF7_POST_TYPE.'_posts_custom_column', $sp4cf7, 'manage_'.SP4CF7_POST_TYPE.'_posts_custom_column', 10, 2 );

		$this->loader->add_action( 'pre_get_posts', $sp4cf7, 'show_transactions_datatable' );
		$this->loader->add_action( 'parse_query', $sp4cf7, 'parse_query' );
		$this->loader->add_action( 'restrict_manage_posts', $sp4cf7, 'manage_posts_filters' );

		$this->loader->add_action( SP4CF7_DOMAIN . '_show_metabox_help', $sp4cf7, 'show_metabox_help' );

		// Adding Stripe setting tab
		$this->loader->add_filter( 'wpcf7_editor_panels', $sp4cf7, 'wpcf7_editor_panels', 10, 3 );
		$this->loader->add_filter( 'post_row_actions', $sp4cf7, 'post_row_actions', 10, 3 );

		$this->loader->add_filter( 'manage_edit-'.SP4CF7_POST_TYPE.'_sortable_columns', $sp4cf7, 'manage_'.SP4CF7_POST_TYPE.'_sortable_columns', 10, 3 );
		$this->loader->add_filter( 'manage_'.SP4CF7_POST_TYPE.'_posts_columns', $sp4cf7, 'manage_'.SP4CF7_POST_TYPE.'_posts_columns', 10, 3 );
		$this->loader->add_filter( 'bulk_actions-edit-'.SP4CF7_POST_TYPE, $sp4cf7, 'bulk_actions_edit_'.SP4CF7_POST_TYPE );

		$this->loader->add_action( 'admin_print_styles-post-new.php', $sp4cf7, 'sp4cf7_admin_style', 11 );
		$this->loader->add_action( 'admin_print_styles-post.php', $sp4cf7, 'sp4cf7_admin_style', 11 );

		// plugin page links
		$this->loader->add_filter('plugin_action_links', $sp4cf7, 'plugin_settings_link', 10, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$sp4cf7 = new \SP4CF7\_Public\SP4CF7_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $sp4cf7, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $sp4cf7, 'enqueue_scripts' );

		$this->loader->add_filter( 'wpcf7_form_class_attr', $sp4cf7, 'wpcf7_form_class_attr' );

		$this->loader->add_action('init', $sp4cf7, 'init');

		$this->loader->add_action( 'wpcf7_init', $sp4cf7, 'wpcf7_init', 10 );

		// $this->loader->add_action( 'wpcf7_save_contact_form', $sp4cf7, 'wpcf7_save_contact_form', 999, 3 );
		$this->loader->add_action( 'wpcf7_before_send_mail', $sp4cf7, 'wpcf7_before_send_mail', 20, 3 );
		
		$this->loader->add_action(SP4CF7_DOMAIN.'_show_test_mode_label', $sp4cf7, 'show_test_mode_label', 10, 1 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->sp4cf7;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	private function init() {
		// Action to load plugin text domain
		add_action( 'init', array( $this, 'sp4cf7_register_post_type' ) );
	}

	public function sp4cf7_register_post_type() {
		
		register_post_type( SP4CF7_POST_TYPE,
		  	array( 
		  		'label' => __( 'Stripe Payments', SP4CF7_DOMAIN ),
		  		'labels' => array(
				    'name' => __( 'Stripe Payments', SP4CF7_DOMAIN ),
				    'singular_name' => __( 'Stripe Payment', SP4CF7_DOMAIN )
			    ),
			    'capability_type' => 'post',
			    'capabilities' => array(
					'read' => true,
					'create_posts'  => false,
					'publish_posts' => false,
				),
				'delete_with_user' => false,
				'map_meta_cap' => true,
				'rest_base' => '',
				'show_in_rest' => false,
			    'description' => __( 'Add Stripe Payments for Contact Form 7', SP4CF7_DOMAIN ),
			    'exclude_from_search' => true,
			    'has_archive' => false,
			    'hierarchical' => false,
			    'menu_icon' => 'dashicons-stripe',
			    'public' => false,
			    'publicly_queryable' => false,
			    'query_var' => false,
			    'rewrite' => false,
			    'show_in_menu' => 'wpcf7',
			    'show_in_nav_menus' => false,
			    'show_ui' => true,
			    'supports' => array( 'title')
	    	)
	  	);
	}

}
