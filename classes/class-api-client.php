<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


require_once WP_PLUGIN_DIR . '/agil-pay-woo/classes/class-client-request.php';


class ApiClient
{
    public $ClientId;
    public $ClientSecret;
    public $Token;
    public $BaseUrl;
    private $client;
    private $session_id;

    public function __construct($baseUrl)
    {
        $this->BaseUrl = $baseUrl;
        $this->client = new ClientRequest(['base_uri' => $baseUrl]);
    }

    public function Init($clientId, $clientSecret)
    {
        $this->session_id = uniqid();
        $this->ClientId = $clientId;
        $this->ClientSecret = $clientSecret;
        $this->Token = $this->GetOAuth2Token($this->BaseUrl, $this->ClientId, $this->ClientSecret);
        return ($this->Token !== null);
    }

    public function GetOAuth2Token($_baseUrl, $_clientId, $_clientSecret)
    {
        $result = null;
        try {
            $client = new ClientRequest(['base_uri' => $_baseUrl]);

            $response = $client->post('oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $_clientId,
                    'client_secret' => $_clientSecret,
                ]
            ]);

            $data = json_decode($response, true);
            // echo json_encode( $data );
            if (isset($data['token_type']) && isset($data['access_token'])) {
                $result = $data['token_type'] . ' ' . $data['access_token'];
            }
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }

        return $result;
    }

    public function Authorize($AuthorizationRequest)
    {
        try {
            $response = $this->client->post('v6/Authorize', [
                'headers' => $this->getHeaders(),
                'json' => $AuthorizationRequest,
            ]);

            $data = json_decode( $response, true );
            return $data;
        } catch (GuzzleException $ex) {
            echo 'entro en exection';
            echo $ex->getMessage();
        }
        return null;
    }

    public function AuthorizeToken($AuthorizationRequest)
    {
        try {
            $response = $this->client->post('v6/AuthorizeToken', [
                'headers' => $this->getHeaders(),
                'json' => $AuthorizationRequest,
            ]);

            $data = json_decode( $response, true );
            return $data;
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        return null;
    }

    public function GetCustomerTokens($CustomerID)
    {
        try {
            $response = $this->client->get('Payment5/GetCustomerTokens', [
                'headers' => $this->getHeaders(),
                'query' => ['CustomerID' => $CustomerID],
            ]);

            $data = json_decode($response, true);
            return $data;
        } catch (GuzzleException $ex) {      
            echo $ex->getMessage();   
        }
        return null;
    }

    public function GetBalance($balanceRequest)
    {
        try {
            $response = $this->client->post('Payment6/GetBalance', [
                'headers' => $this->getHeaders(),
                'json' => $balanceRequest,
            ]);

            $data = json_decode( $response, true );
            return $data;
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        return null;
    }

    private function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'SessionId' => $this->session_id,
            'SiteId' => $this->ClientId,
            'Authorization' => $this->Token,
        ];
    }
}
