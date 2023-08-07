<?php


defined( 'ABSPATH' ) || exit;

class WC_Gateway_AgilPay extends WC_Payment_Gateway {


    /**
	 * Constructor for the gateway.
	 */
	public function __construct() {

		$this->id                 = 'agilpay';
		$this->icon               = apply_filters( 'woocommerce_agilpay_icon', '' );
		$this->has_fields         = false;
		$this->method_title       = "Agil Pay Methods";
		$this->method_description = "Agil Pay Methods Description";

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		// $this->title        = $this->get_option( 'title' );
		// $this->description  = $this->get_option( 'description' );
		// $this->instructions = $this->get_option( 'instructions' );

		// BACS account fields shown on the thanks page and in emails.
		// $this->account_details = get_option(
		// 	'woocommerce_bacs_accounts',
		// 	array(
		// 		array(
		// 			'account_name'   => $this->get_option( 'account_name' ),
		// 			'account_number' => $this->get_option( 'account_number' ),
		// 			'sort_code'      => $this->get_option( 'sort_code' ),
		// 			'bank_name'      => $this->get_option( 'bank_name' ),
		// 			'iban'           => $this->get_option( 'iban' ),
		// 			'bic'            => $this->get_option( 'bic' ),
		// 		),
		// 	)
		// );

		// Actions.
		// add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		// add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'save_account_details' ) );
		// add_action( 'woocommerce_thankyou_bacs', array( $this, 'thankyou_page' ) );

		// Customer Emails.
		// add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
	}

    public function init_form_fields() {

		$this->form_fields = array(
			'enabled'         => array(
				'title'   => __( 'Enable/Disable', 'woocommerce' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable', 'woocommerce' ),
				'default' => 'no',
			),
			'title'           => array(
				'title'       => __( 'Title', 'woocommerce' ),
				'type'        => 'safe_text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default'     => __( 'Direct bank transfer', 'woocommerce' ),
				'desc_tip'    => true,
			),
			'description'     => array(
				'title'       => __( 'Description', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
				'default'     => __( 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.', 'woocommerce' ),
				'desc_tip'    => true,
			),
			'instructions'    => array(
				'title'       => __( 'Instructions', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Instructions that will be added to the thank you page and emails.', 'woocommerce' ),
				'default'     => '',
				'desc_tip'    => true,
			),
			'account_details' => array(
				'type' => 'account_details',
			),
		);

	}

}