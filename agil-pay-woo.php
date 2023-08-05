<?php
/**
 * Plugin Name: Agil Pay for WooCommerce
 * Plugin URI: https://zenx5.pro
 * Description: ...
 * Version: 1.0.0
 * Author: Octavio Martinez y Moises Rodriguez
 * Author URI: https://zenx5.pro
 * Text Domain: woocommerce
 * Domain Path: /i18n/languages/
 * Requires at least: 5.9
 * Requires PHP: 7.2
 *
 * @package WooCommerce
 */

 require_once 'classes/class-agil-payment-method.php';
 $nameclass = 'AgilPaymentMethod';

 register_activation_hook(__FILE__, [$nameclass, 'activation']);
 register_deactivation_hook(__FILE__, [$nameclass, 'deactivation']);
 register_uninstall_hook(__FILE__, [$nameclass, 'uninstall']);

 add_action('init', [$nameclass, 'init']);