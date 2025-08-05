<?php
/**
 * Configuración General
 * @link       https://perfectpool.cl
 * @since      1.0.0
 * @package    wc-ciudades-y-estados-de-mexico
 * @subpackage wc-ciudades-y-estados-de-mexico/classes
 */

defined( 'ABSPATH' ) || exit;

if(!class_exists('MKRAPEL_MX_Settings')) :

class MKRAPEL_MX_Settings {
    public $screen_id;
	public function __construct() {
		
	}
	public function enqueue_styles_and_scripts($hook) {
		if(strpos($hook, 'page_checkout_form') === false) {
			return;
		}

		$deps = array('jquery', 'jquery-ui-dialog', 'jquery-ui-sortable', 'jquery-tiptip', 'woocommerce_admin', 'select2', 'wp-color-picker');

		wp_enqueue_style('woocommerce_admin_styles');
		wp_enqueue_style('mkrapel-mx-admin-style', MKRAPEL_MX_ASSETS_URL . 'css/mkrapel-mx-admin.css', MKRAPEL_MX_VERSION);
		wp_enqueue_script('mkrapel-mx-admin-script', MKRAPEL_MX_ASSETS_URL . 'js/mkrapel-mx-admin.js', $deps, MKRAPEL_MX_VERSION, true);
	}
	public function MKRAPEL_MX_capability() {
		$allowed = array('manage_woocommerce', 'manage_options');
		$capability = apply_filters('mkrapel_mx_required_capability', 'manage_woocommerce');

		if(!in_array($capability, $allowed)){
			$capability = 'manage_woocommerce';
		}
		return $capability;
	}
	public function admin_menu() {
		$capability = $this->MKRAPEL_MX_capability();
		$this->screen_id = add_submenu_page('woocommerce', __('Diseño del Formulario de Pago', 'wc-ciudades-y-regiones-de-chile'), __('Formularios de Pago', 'wc-ciudades-y-regiones-de-chile'), $capability, 'checkout_form', array($this, 'output_settings'));
		$this->screen_id = add_submenu_page('woocommerce', __('Zonas de Envío', 'wc-ciudades-y-regiones-de-chile'), __('Zonas de Envío', 'wc-ciudades-y-regiones-de-chile'), $capability, 'wc-settings&tab=shipping', array($this, 'output_settings'));
		$this->screen_id = add_submenu_page('woocommerce', __('Nueva Zona de Envío', 'wc-ciudades-y-regiones-de-chile'), __('Nueva Zona de Envío', 'wc-ciudades-y-regiones-de-chile'), $capability, 'wc-settings&tab=shipping&zone_id=new', array($this, 'output_settings'));
		$this->screen_id = add_submenu_page('woocommerce', __('Medios de Pago', 'wc-ciudades-y-regiones-de-chile'), __('Medios de Pago', 'wc-ciudades-y-regiones-de-chile'), $capability, 'wc-settings&tab=checkout', array($this, 'output_settings'));
	}
	public function add_screen_id($ids){
		$ids[] = 'woocommerce_page_checkout_form';
		$ids[] = strtolower(__('WooCommerce', 'wc-ciudades-y-regiones-de-chile')) .'_page_checkout_form';

		return $ids;
	}
	public function plugin_action_links($links) {
		$config_link    = '<a href="'.admin_url('admin.php?page=checkout_form').'">'. __('Configuración Checkout', 'wc-ciudades-y-regiones-de-chile') .'</a>';
		$info_link      = '<a href="">'. __('Documentación', 'wc-ciudades-y-estados-de-mexico') .'</a>';
		array_unshift($links, $config_link, $info_link);
		return $links;
	}
	private function output_review_request_link(){  }
	public function output_settings(){
		$this->output_review_request_link();
		$tab = $this->get_current_tab();

		echo '<div class="mkrapel-mx-wrap">';
		if($tab === 'advanced_settings'){			
			$advanced_settings = MKRAPEL_MX_Settings_Advanced::instance();	
			$advanced_settings->render_page();		
		}else{
			$general_settings = MKRAPEL_MX_Settings_General::instance();	
			$general_settings->render_page();
		}
		echo '</div">';
	}
	public function get_current_tab(){
		return isset( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : 'fields';
	}
}

endif;

