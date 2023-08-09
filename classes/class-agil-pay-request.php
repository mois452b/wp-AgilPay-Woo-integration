<?php

class AgilPayRequest {
    public static function request( ) {
        self::includesModels( );

		$client = new ApiClient("https://sandbox-webapi.agilpay.net/");
		// OAUTH 2.
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

    }

    public static function includesModels( ) {
		require_once './ApiClient.php';
		require_once '../models/class-account-type.php';
		require_once '../models/class-balance-request.php';
		require_once '../models/class-authorization-request.php';
		
    }
}