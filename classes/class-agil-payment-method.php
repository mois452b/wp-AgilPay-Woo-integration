<?php

defined( 'ABSPATH' ) || exit;

class AgilPaymentMethod {

    public static function activation() {
    }

    public static function deactivation() {
    }

    public static function uninstall() {
    }

    public static function init() {
        require_once 'class-wc-gateway-agil-pay.php';
        add_filter( 'woocommerce_payment_gateways', [__CLASS__, 'add_payment_method']);
    }

    public static function add_payment_method( $load_gateways ) {
        $load_gateways[] = 'WC_Gateway_AgilPay';
        return $load_gateways;
    }
}
