<?php

namespace App\Traits;

use SoapClient;

trait RequestSoap
{//126704 127607
    private $http = 'https://pelicanoconstrucoes127607.rm.cloudtotvs.com.br:8059';

    private $login = 'fluig';

    private $password = 'Centrium505050@@';

    private $xml;

    private $soapClient;

    public function __construct()
    {
        $this->http = env('TOTVS_WS_WSDL');
        $this->login = env('TOTVS_WS_USER_NAME');
        $this->password = env('TOTVS_WS_PASSWORD');
    }

    public function setXml($value)
    {
        $this->xml = $value;

        return $this;
    }

    public function getFilter()
    {
        return $this->xml;
    }

    private function callSoap()
    {
        $this->soapClient = new SoapClient(
            $this->http, [
                'login' => $this->login,
                'password' => $this->password,
            ]
        );

    }

    private function argumentoSoap()
    {
        $arguments = ['SaveRecord' => [
            'DataServerName' => 'MOVMOVIMENTOTBCDATA',
            'XML' => ($envelopeXML),
            'Contexto' => 'CODSISTEMA=G;CODCOLIGADA=1;CODUSUARIO='.$usuario,
        ]];
    }

    private function executaSoap()
    {
        //Executando a requisição Soap
        $this->soapClient = $client->__soapCall('SaveRecord', $arguments);
    }

    /**
     * @return SoapClient
     *
     * @throws Exception
     */
    private function getSoap()
    {
        if (! isset($this->soapClient)) {
            throw new Exception('SoapClient Not Itinialized');
        }

        return $this->soapClient;
    }

    /**
     * @param  $wsdll
     */
    private function initSoap()
    {

        $totvsAddress = $this->getTotvsAddress();
        $totvsPort = $this->getTotvsPort();
        $wsdlPath = $this->getWsdlPath();

        $wsdl = sprintf('%s:%s/%s', $totvsAddress, $totvsPort, $wsdlPath);

        $opts = [
            'http' => [
                'user_agent' => 'PelicanoSoapClient',
            ],
        ];

        $context = stream_context_create($opts);

        $soapClientOptions = [
            'login' => $this->login,
            'password' => $this->password,
            'encoding' => 'UTF-8',
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => $context,
        ];

        $this->soapClient = new SoapClient($wsdl, $soapClientOptions);
    }
}
