<?php

class CustomCurl {
    private $url;
    private $method;
    private $headers;
    private $data;

    public function __construct($url) {
        $this->url = $url;
        $this->method = 'GET';
        $this->headers = [];
        $this->data = null;
    }

    public function setMethod($method) {
        $this->method = strtoupper($method);
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function addHeader($header) {
        $this->headers[] = $header;
    }

    public function execute() {
        $curl = curl_init();

        $options = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers,
        ];

        if ($this->method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $this->data;
        } elseif ($this->method !== 'GET') {
            $options[CURLOPT_CUSTOMREQUEST] = $this->method;
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Error de cURL: ' . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }
}