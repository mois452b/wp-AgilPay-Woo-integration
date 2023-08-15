<?php



class ClientRequest {
    private $baseUri;
    private $headers;

    public function __construct($config = []) {
        $this->baseUri = isset($config['base_uri']) ? $config['base_uri'] : '';
        $this->headers = isset($config['headers']) ? $config['headers'] : [];
    }
    public function postTest($endpoint, $data = []) {
        $url = $this->baseUri . ltrim($endpoint, '/');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data), // Proar tamben con http_build_query($data)
        ]);
        $response = curl_exec($curl);
        if ($response === false) {
            $error_message = curl_error($curl);
            echo "Error: $error_message";
            return null;
        }
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($response_code !== 200) {
            echo "Error en la respuesta HTTP. Código: $response_code";
            return null;
        }
        curl_close($curl);
        return $response;
    }

    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }

    public function get($endpoint, $query = []) {
        return $this->request('GET', $endpoint, [], $query);
    }

    private function request($method, $endpoint, $data = [], $query = []) {
        $url = $this->baseUri . ltrim($endpoint, '/');

        $ch = curl_init();

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif ($method === 'GET') {
            if (!empty($query)) {
                $url .= '?' . http_build_query($query);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($this->headers));

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
