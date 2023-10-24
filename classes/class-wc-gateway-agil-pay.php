<?php


defined( 'ABSPATH' ) || exit;

class WC_Gateway_AgilPay extends WC_Payment_Gateway {

    /**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		$this->id                 = 'agilpay';
		$this->icon               = apply_filters( 'woocommerce_agilpay_icon', '' );
		$this->has_fields         = true;
		$this->order_button_text  = "Realizar pago";
		$this->method_title       = "Agil Pay Methods";
		$this->method_description = "Pagos con tarjeta de credito usando el servicio de Agil Pay";
		$this->title			  = $this->get_option( 'title' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Actions.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		// add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'save_account_details' ) );
		// add_action( 'woocommerce_thankyou_bacs', array( $this, 'thankyou_page' ) );

		// Customer Emails.
		// add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
	}

    public function init_form_fields() {
		$this->form_fields = array(
			'title'         => array(
				'field_name'  => 'title',
				'title'       => 'title method',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => 'Agil Pay',
				'desc_tip'    => true,
			),
			'shop_id'         => array(
				'field_name'  => 'agilpay_shop_id',
				'title'       => 'Merchant key',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			),
			'client_public_id'=> array(
				'field_name'  => 'agilpay_client_public_id',
				'title'       => 'Client key',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			),
			'client_secrect_id'=> array(
				'field_name'  => 'agilpay_client_secrect_id',
				'title'       => 'Secret key',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			)
		);

	}

	public function process_payment( $order_id ) {
        $order = wc_get_order( $order_id );

		include 'class-agil-pay-request.php';

        AgilPayRequest::$merchant_key 	= $this->get_option( 'shop_id' );
        AgilPayRequest::$client_id 		= $this->get_option( 'client_public_id' );
        AgilPayRequest::$secret 		= $this->get_option( 'client_secrect_id' );
		AgilPayRequest::$month 			= explode( '/', $_POST['agilpay_card_expiry'] )[0];
		AgilPayRequest::$year 			= explode( '/', $_POST['agilpay_card_expiry'] )[1];
		AgilPayRequest::$cvv 			= $_POST['agilpay_card_cvv'];
		AgilPayRequest::$card 			= $_POST['agilpay_card_number'];
		AgilPayRequest::$zipcode 		= $_POST['billing_postcode'];
		AgilPayRequest::$amount 		= $order->get_total( );
		AgilPayRequest::$customer_email = $_POST['billing_email'];
		AgilPayRequest::$customer_name 	= $_POST['billing_first_name'].' '.$_POST['billing_last_name'];

		$payRequest = AgilPayRequest::request( );

		if( $payRequest['ResponseCode'] == '44' ) {
			wc_add_notice( 'Credenciales invalidas.', 'error' );
			return array(
				'result'   	=> 'fail',
				'message'	=> 'Autenticacion fallida.'
			);
		}
		if( $payRequest['ResponseCode'] == '94' ) {
            wc_add_notice( 'Transaccion duplicada.', 'error' );
			return array(
				'result'   	=> 'fail',
				'message'	=> 'transaccion duplicada'
			);
		}
		if( $payRequest['ResponseCode'] != '00' ) {
            wc_add_notice( 'Error de tansaccion.', 'error' );
			return array(
				'result'   => 'fail',
			);
		}
		$order->payment_complete();
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}

	public function payment_fields(){
		include WP_PLUGIN_DIR.'/agil-pay-woo/templates/payment-details.php';
		echo "<script>";
        include WP_PLUGIN_DIR.'/agil-pay-woo/templates/payment-details-app.js';
        echo "</script>";
	}

}