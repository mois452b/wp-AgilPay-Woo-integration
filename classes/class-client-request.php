<?php

class ClientRequest {
    private $baseUri;
    private $headers;

    public function __construct($config = []) {
        $this->baseUri = isset($config['base_uri']) ? $config['base_uri'] : '';
        $this->headers = isset($config['headers']) ? $config['headers'] : [];
    }

    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }

    public function get($endpoint, $data = []) {
        return $this->request('GET', $endpoint, $data);
    }

    private function request($method, $endpoint, $data = [], $query = []) {
        $url = $this->baseUri . ltrim($endpoint, '/');

        $ch = curl_init();

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if( isset( $data['json'] ) ) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['json']) );
            }
            else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data['form_params'] ));
            }
        } elseif ($method === 'GET') {
            if( !empty( $data['query'] ) ) {
                $url .= '?' . http_build_query( $data['query'] );
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders( $data['headers'] ?? [] ) );

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }

    private function formatHeaders($headers) {
        $formattedHeaders = [];

        foreach ($headers as $key => $value) {
            $formattedHeaders[] = $key . ': ' . $value;
        }

        return $formattedHeaders;
    }
}
