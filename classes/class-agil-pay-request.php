<?php

defined( 'ABSPATH' ) || exit;

require_once 'class-api-client.php';
require_once WP_PLUGIN_DIR . '/agil-pay-woo/models/class-account-type.php';
require_once WP_PLUGIN_DIR . '/agil-pay-woo/models/class-balance-request.php';
require_once WP_PLUGIN_DIR . '/agil-pay-woo/models/class-authorization-request.php';

class AgilPayRequest {
    public static $url = 'https://webapi.agilpay.net/';
    public static $client_id;
    public static $secret;
    public static $merchant_key;
    public static $customer_id;

    // PAYMENT VALUES
    public static $amount;
    public static $card;
    public static $month;
    public static $year;
    public static $zipcode;
    public static $cvv;
	
    public static $customer_email;
    public static $customer_name;

    public static function request( ) {
		try {
			$client = new ApiClient( AgilPayRequest::$url );
			// OAUTH 2.
			$result = false;
			$result = $client->Init( AgilPayRequest::$client_id, AgilPayRequest::$secret );

			if( !$result ) {
				return [
					'ResponseCode' 	=> 44,
					'message'		=> 'Autenticacion fallida.'
				];
			};

			// CUSTOMER TOKENS
			$resultTokens = $client->GetCustomerTokens( AgilPayRequest::$customer_id );

			// Balance
			$balanceRequest = new BalanceRequest( );
			$balanceRequest->MerchantKey = AgilPayRequest::$merchant_key;
			$balanceRequest->CustomerId = AgilPayRequest::$customer_id;
			$resultBalance = $client->GetBalance( $balanceRequest );

			// PAYMENT
			$authorizationRequest = new AuthorizationRequest();
			$authorizationRequest->MerchantKey 			= AgilPayRequest::$merchant_key;
			$authorizationRequest->AccountNumber 		= AgilPayRequest::$card;
			$authorizationRequest->ExpirationMonth 		= AgilPayRequest::$month;
			$authorizationRequest->ExpirationYear 		= AgilPayRequest::$year;
			$authorizationRequest->CustomerName 		= AgilPayRequest::$customer_name;
			$authorizationRequest->CustomerID 			= AgilPayRequest::$customer_id;
			$authorizationRequest->AccountType 			= AccountType::Credit_Debit;
			$authorizationRequest->CustomerEmail 		= AgilPayRequest::$customer_email;
			$authorizationRequest->ZipCode 				= AgilPayRequest::$zipcode;
			$authorizationRequest->Amount 				= AgilPayRequest::$amount;
			$authorizationRequest->Currency 			= "840";
			$authorizationRequest->Tax 					= "0";
			$authorizationRequest->Invoice 				= "123465465";
			$authorizationRequest->Transaction_Detail 	= "payment from agil pay";
			$authorizationRequest->CVV 					= AgilPayRequest::$cvv;

			$resultPayment = $client->Authorize( $authorizationRequest->getData() );
			return $resultPayment;
		} catch (\Throwable $th) {
			throw $th;
		}
		
    }

}