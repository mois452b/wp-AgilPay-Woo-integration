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
		$this->title        = $this->get_option( 'title' );
		$this->description  = $this->get_option( 'description' );
		$this->instructions = $this->get_option( 'instructions' );

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

	public function process_payment( $order_id ) {
		require_once './ApiClient.php';
		require_once '../models/AccountType.php';
		require_once '../models/BalanceRequest.php';
		require_once '../models/AuthorizationRequest.php';

        $order = wc_get_order( $order_id );
	
		echo 'Hola MUndo';
		return;
		
		$client = new ApiClient("https://sandbox-webapi.agilpay.net/");
		// OAUTH 2.0
		$result = false;

		$client_id = "API-001";
		$secret = "Dynapay";

		$result = $client->Init($client_id, $secret);
		// Balance
		$merchant_key = "TEST-001";
		$customer_id = "123456";
		$resultTokens = $client->GetCustomerTokens($customer_id);

		$balanceRequest = new BalanceRequest();
		$balanceRequest->MerchantKey = $merchant_key;
		$balanceRequest->CustomerId = $customer_id;
		$resultBalance = $client->GetBalance($balanceRequest);

		// PAYMENT
		$amount = "1.02";
		$card = "4242424242424242";
		$month = "01";
		$year = "29";
		$zipcode = "33167";
		$cvv = "123";

		$authorizationRequest = new AuthorizationRequest();
		$authorizationRequest->MerchantKey = $merchant_key;
		$authorizationRequest->AccountNumber = $card;
		$authorizationRequest->ExpirationMonth = $month;
		$authorizationRequest->ExpirationYear = $year;
		$authorizationRequest->CustomerName = "Test User";
		$authorizationRequest->CustomerID = $customer_id;
		$authorizationRequest->AccountType = AccountType::Credit_Debit;
		$authorizationRequest->CustomerEmail = "testuser@gmail.com";
		$authorizationRequest->ZipCode = $zipcode;
		$authorizationRequest->Amount = $amount;
		$authorizationRequest->Currency = "840";
		$authorizationRequest->Tax = "0";
		$authorizationRequest->Invoice = "123465465";
		$authorizationRequest->Transaction_Detail = "payment information detail";
		$authorizationRequest->CVV = $cvv;

		$resultPayment = $client->Authorize( $authorizationRequest->getData() );

        // Aquí puedes agregar lógica adicional para procesar el pago si fuera necesario.

        // Marcar el pedido como completado (pago exitoso).
        // $order->payment_complete();

        // // Redirigir al cliente a la página de agradecimiento o de confirmación de pedido.
        // return array(
        //     'result'   => 'success',
        //     'redirect' => $this->get_return_url( $order ),
        // );
    }

    public function payment_fields() {
        echo '<div id="mi_metodo_pago_personalizado">';
        echo '<h3>Detalles de Pago</h3>';
        echo '<p>Por favor, ingresa los detalles de tu tarjeta de crédito o débito:</p>';

        // Mostrar campos para la información de la tarjeta (número, expiración, CVV).
        // Puedes personalizar estos campos según tus necesidades.
        echo '<p><label for="card_number">Número de Tarjeta:</label>';
        echo '<input type="text" id="card_number" name="card_number" required /></p>';

        echo '<p><label for="card_expiry">Fecha de Expiración:</label>';
        echo '<input type="text" id="card_expiry" name="card_expiry" placeholder="MM/AA" required /></p>';

        echo '<p><label for="card_cvv">CVV:</label>';
        echo '<input type="text" id="card_cvv" name="card_cvv" required /></p>';

        echo '</div>';
    }

}