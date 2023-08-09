<?php

class AgilPayRequest {
    public static $url          = 'https://sandbox-webapi.agilpay.net/';
    public static $client_id    = 'API-001';
    public static $secret       = 'Dynapay';
    public static $merchant_key = 'TEST-001';
    public static $customer_id  = '123456';

    // PAYMENT VALUES
    public static $amount   = "1.02";
    public static $card     = "4242424242424242";
    public static $month    = "01";
    public static $year     = "29";
    public static $zipcode  = "33167";
    public static $cvv      = "123";

    public static function request( ) {
        self::includesModels( );

		$client = new ApiClient( AgilPayRequest::$url );
		// OAUTH 2.
		$result = false;
		$result = $client->Init( AgilPayRequest::$client_id, AgilPayRequest::$secret );

        // CUSTOMER TOKENS
		$resultTokens = $client->GetCustomerTokens( AgilPayRequest::$customer_id );

		// Balance
		$balanceRequest = new BalanceRequest( );
		$balanceRequest->MerchantKey = AgilPayRequest::$merchant_key;
		$balanceRequest->CustomerId = AgilPayRequest::$customer_id;
		$resultBalance = $client->GetBalance( $balanceRequest );

        // PAYMENT
		$authorizationRequest = new AuthorizationRequest();
		$authorizationRequest->MerchantKey = AgilPayRequest::$merchant_key;
		$authorizationRequest->AccountNumber = AgilPayRequest::$card;
		$authorizationRequest->ExpirationMonth = AgilPayRequest::$month;
		$authorizationRequest->ExpirationYear = AgilPayRequest::$year;
		$authorizationRequest->CustomerName = "Test User";
		$authorizationRequest->CustomerID = AgilPayRequest::$customer_id;
		$authorizationRequest->AccountType = AccountType::Credit_Debit;
		$authorizationRequest->CustomerEmail = "testuser@gmail.com";
		$authorizationRequest->ZipCode = AgilPayRequest::$zipcode;
		$authorizationRequest->Amount = AgilPayRequest::$amount;
		$authorizationRequest->Currency = "840";
		$authorizationRequest->Tax = "0";
		$authorizationRequest->Invoice = "123465465";
		$authorizationRequest->Transaction_Detail = "payment information detail";
		$authorizationRequest->CVV = AgilPayRequest::$cvv;

		$resultPayment = $client->Authorize( $authorizationRequest->getData() );
    }

    public static function includesModels( ) {
		require_once './ApiClient.php';
		require_once '../models/class-account-type.php';
		require_once '../models/class-balance-request.php';
		require_once '../models/class-authorization-request.php';
		
    }
}