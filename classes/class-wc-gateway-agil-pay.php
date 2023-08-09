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
		$this->order_button_text  = "Pagar con Agil Pay";
		$this->method_title       = "Agil Pay Methods";
		$this->method_description = "Agil Pay Methods Description";
		$this->title			  = "Agil Pay";

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
			'shop_id'         => array(
				'title'       => 'ID Comercio',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			),
			'client_public_id'=> array(
				'title'       => 'Llave Publica',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			),
			'client_secrect_id'=> array(
				'title'       => 'Llave Privada',
				'type'        => 'safe_text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => true,
			)
		);

	}

	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		// WC()->cart->empty_cart();
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}

	public function payment_fields(){
		?>
		<div>
        	<h3>Detalles de Pago</h3>
        	<p>Por favor, ingresa los detalles de tu tarjeta de crédito o débito:</p>
			<table>
				<tr>
					<th>
						<label for="agilpay_card_number">Número de Tarjeta:</label>
					</th>
					<td>
						<input type="number" id="agilpay_card_number" name="agilpay_card_number" placeholder="XXXX-XXXX-XXXX-XXXX" required />
					</td>
				</tr>
				<tr>
					<th>
						<label for="agilpay_card_expiry">Fecha de Expiración:</label>
					</th>
					<td>
						<input type="date" id="agilpay_card_expiry" name="agilpay_card_expiry" placeholder="MM/AA" required />
					</td>
				</tr>
				<tr>
					<th>
						<label for="agilpay_card_cvv">CVV:</label>
					</th>
					<td>
						<input type="number" id="agilpay_card_cvv" name="agilpay_card_cvv" placeholder="000" required />
					</td>
				</tr>
			</table>
        </div>
		<?php
	}

}