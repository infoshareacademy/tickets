<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 05.11.15
 * Time: 16:36
 */

namespace Tickets\Connectors;


class AllegroApiConnector
{
    const APIURL = 'https://webapi.allegro.pl/service.php?wsdl';
    const LOGIN = 'Ivone107';
    const PASSWORD = 'Kopcioland1';
    const APIKEY = '99275d6f';
//    const OPTIONS = [
//        'features' => SOAP_SINGLE_ELEMENT_ARRAYS
//    ];
    protected $apiVersion;

    private static $idSesson;
//    private $optionToConnect;

//    $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
//


    public function login() {
        $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
        $client = new \SoapClient(self::APIURL, $options);

        if($this->apiVersion = null) {
            $this->getApiVersion();
        }

        $request = [
            'userLogin' => self::LOGIN,
            'userPassword' => self::PASSWORD,
            'countryId' => 1,
            'webapiKey' => self::APIKEY,
            'localVersion' => $this->apiVersion
        ];

        $response = $client->doLogin($request);
        self::$idSesson = $response->sessionHandlePart;
    }

    public function getIdSesion() {
        if(!self::$idSesson) {
            $this->login();
        }
        return self::$idSesson;
    }

    private function getApiVersion() {
        $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
        $client = new \SoapClient(self::APIURL, $options);

        $request = [
            'countryId' => 1,
            'webapiKey' => self::APIKEY
        ];

        $status = $client->doQueryAllSysStatus($request);
        $this->apiVersion = $status->sysCountryStatus->item[0]->verKey;
    }

}

