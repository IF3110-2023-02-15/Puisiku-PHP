<?php

class SOAPService {
    private $client;

    public function __construct($endpoint)
    {
        $baseUrl = getenv('SOAP_BASE_URL');
        $opts = array(
            'http' => array(
                'header' => 'x-api-key: ' . getenv('SOAP_API_KEY'),
            ),
        );
        $context = stream_context_create($opts);
        $this->client = new SoapClient($baseUrl . $endpoint . "?wsdl", ['stream_context' => $context]);
    }

    public function call($method, $params) {
        try {
            $result = $this->client->__soapCall($method, [$params]);
            return $result;
        } catch (SoapFault $fault) {
            echo "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
        }
    }
}
