<?php
/**
 * Configuración General del Plugin
 * @link       https://perfectpool.cl
 * @since      1.0.0
 * @package    wc-ciudades-y-regiones-de-mexico
 * @subpackage wc-ciudades-y-regiones-de-mexico/classes
 */

defined( 'ABSPATH' ) || exit;

if(!class_exists('MKRAPEL_MX')):

class MKRAPEL_MX {
	const TEXT_DOMAIN = 'wc-ciudades-y-estados-de-mexico';

	public function __construct() {
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}
    private function load_dependencies() {
		if(!function_exists('is_plugin_active')){
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx-utils.php';
		require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx-settings.php';
		require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx-settings-general.php';
		require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx-settings-advanced.php';
		require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx-checkout.php';
	}
	private function set_locale() {
		add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
	}
	public function load_plugin_textdomain(){
		$locale = apply_filters('plugin_locale', get_locale(), self::TEXT_DOMAIN);
		// load_textdomain(self::TEXT_DOMAIN, WP_LANG_DIR.'/wc-ciudades-y-regiones-de-chile/'.self::TEXT_DOMAIN.'-'.$locale.'.mo');
		// load_plugin_textdomain(self::TEXT_DOMAIN, false, dirname(MKRAPEL_MX_BASE_NAME) . '/languages/');
	}
	private function define_admin_hooks() {
		$plugin_admin = new MKRAPEL_MX_Settings();

		add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles_and_scripts'));
		add_action('admin_menu', array($plugin_admin, 'admin_menu'));
		add_filter('woocommerce_screen_ids', array($plugin_admin, 'add_screen_id'));
		add_filter('plugin_action_links_'.MKRAPEL_MX_BASE_NAME, array($plugin_admin, 'plugin_action_links'));
		// add_filter('plugin_row_meta', array($plugin_admin, 'plugin_row_meta'), 10, 2);

		$general_settings = new MKRAPEL_MX_Settings_General();
		add_action('after_setup_theme', array($general_settings, 'define_admin_hooks'));
	}
	private function define_public_hooks() {
		//if(!is_admin() || (defined( 'DOING_AJAX' ) && DOING_AJAX)){
			$plugin_checkout = new MKRAPEL_MX_Checkout();
			add_action('wp_enqueue_scripts', array($plugin_checkout, 'enqueue_styles_and_scripts'));
			add_action('after_setup_theme', array($plugin_checkout, 'define_public_hooks'));
		//}
	}
}

endif;