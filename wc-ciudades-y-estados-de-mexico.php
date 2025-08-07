<?php
/*
Plugin Name: MkRapel Estados y Ciudades de México para WooCommerce
Plugin URI: https://perfectpool.cl
Description: Plugin para seleccionar estados y ciudades de México en WooCommerce.
Version: 1.0.0
Author: Perfect Pool
Author URI: https://perfectpool.cl
License: GPLv3
Requires at least: 5.0
Tested up to: 5.8
Requires PHP: 7.1
Text Domain: wc-ciudades-y-estados-de-mexico
WC requires at least: 6.0.0
WC tested up to: 6.0.0
*/

if (!defined('ABSPATH')) exit;

if (!function_exists('is_woocommerce_active')) {
    function is_woocommerce_active() {
        $active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('woocommerce/woocommerce.php', $active_plugins)
            || array_key_exists('woocommerce/woocommerce.php', $active_plugins)
            || class_exists('WooCommerce');
    }
}

if (is_woocommerce_active()) {
    define('MKRAPEL_MX_VERSION', '1.0');
    !defined('MKRAPEL_MX_BASE_NAME') && define('MKRAPEL_MX_BASE_NAME', plugin_basename(__FILE__));
    !defined('MKRAPEL_MX_PATH') && define('MKRAPEL_MX_PATH', plugin_dir_path(__FILE__));
    !defined('MKRAPEL_MX_URL') && define('MKRAPEL_MX_URL', plugins_url('/', __FILE__));
    !defined('MKRAPEL_MX_ASSETS_URL') && define('MKRAPEL_MX_ASSETS_URL', MKRAPEL_MX_URL . 'assets/');

    require_once MKRAPEL_MX_PATH . 'classes/class-mkrapel-mx.php';
    require_once MKRAPEL_MX_PATH . 'classes/mkrapel-mx-states-places.php';
    require_once MKRAPEL_MX_PATH . 'classes/mkrapel-mx-filter-by-cities.php';

    function run_mkrapel_mx() {
        $plugin = new MKRAPEL_MX();
    }
    run_mkrapel_mx();

    global $pagenow;
    $GLOBALS['wc_states_places'] = new MkRapel_Region_Ciudad_MX(__FILE__);

    add_filter('woocommerce_shipping_methods', 'add_filters_by_cities_method');
    add_action('woocommerce_shipping_init', 'filters_by_cities_method');

    function add_filters_by_cities_method($methods) {
        $methods['filters_by_cities_shipping_method'] = 'Filters_By_Cities_Method_MX';
        return $methods;
    }
}