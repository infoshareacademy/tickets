<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 05-06.11.15
 * Time: 16:36
 */



namespace Tickets\Connectors;


class AllegroConnector
{
    const APIURL = 'https://webapi.allegro.pl/service.php?wsdl';
    const LOGIN = 'Ivone107';
    const PASSWORD = 'Kopcioland1';
    const APIKEY = '99275d6f';

    protected $apiVersion;

    private static $idSession;

    private $client;
    private $errorOperation;

    public function __construct($client = null)
    {
        if($client) {
            $this->client = $client;
        } else {
            $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
            $this->client = new \SoapClient(self::APIURL, $options);
        }
//todo: throw exceptions
//        $this->errorOperation = null;
        $this->login();
    }

    private function login() {

        if($this->apiVersion == null) {
            $this->getApiVersion();
        }

        $request = [
            'userLogin' => self::LOGIN,
            'userPassword' => self::PASSWORD,
            'countryCode' => 1,
            'webapiKey' => self::APIKEY,
            'localVersion' => $this->apiVersion
        ];

        try {
            $response = $this->client->doLogin($request);
            self::$idSession = $response->sessionHandlePart;
        }
        catch (\SoapFault $error) {
            $this->errorOperation = 'Error '. $error->faultcode . ': '. $error->faultstring;
        }

    }

    public function getIdSesion() {
        if(!self::$idSession) {
            $this->login();
        }
        return self::$idSession;
    }

    private function getApiVersion() {
        $request = [
            'countryId' => 1,
            'webapiKey' => self::APIKEY
        ];

        try {
            $status = $this->client->doQueryAllSysStatus($request);
            $this->apiVersion = $status->sysCountryStatus->item[0]->verKey;
        }
        catch (\SoapFault $error) {
            $this->errorOperation = 'Error '. $error->faultcode . ': '. $error->faultstring;
        }
    }

    private function collectId($idCategory) {
        $request = [
            'filterOptions' => [[
                'filterId' => 'category',
                'filterValueId' => [$idCategory]
            ]],
            'countryId' => 1,
            'webapiKey' => self::APIKEY
        ];
        $itemList = $this->client->doGetItemsList($request);
        $list = $itemList->itemsList->item;
        $idTable = [];

        foreach ($list as $itemArray) {
            foreach ($itemArray as $key => $value) {
                if ($key == 'itemId') {
                    array_push($idTable, $value);
                }
            }
        }
        return $idTable;
    }

    private function getItemInfo($tableId) {
        $request = [
            'sessionHandle' => self::$idSession,
            'itemsIdArray' => $tableId
        ];
        $response = $this->client->doGetItemsInfo($request);
        //it needs error handeling
        return $response;
    }

    private function getOnlyFoundItems($fullAllegroAnswer) {
        $items = $fullAllegroAnswer->arrayItemListInfo->item;
        return $items;
    }

    private function getDetails($itemsId) {
        $limitFromAllegro = 25;  // allegro returns only 25 item's details
        $numberOfArguments = count($itemsId);
        $numberOfLoops = (int)($numberOfArguments / $limitFromAllegro);
        // share table on subtable (per 25 positions)
        $sharedId = array_chunk($itemsId, $limitFromAllegro);

        $collectionItems = [];

        for ($i = 0; $i < $numberOfLoops; $i++) {
            $answerFromAllegro = $this->getItemInfo($sharedId[$i]);
            $answerFromAllegro = $this->getOnlyFoundItems($answerFromAllegro);
            $collectionItems = array_merge((array)$collectionItems, (array)$answerFromAllegro);
        }
        return $collectionItems;
    }

    public function getItems($methodName) {
        switch ($methodName) {
            case 'sport':
                $idCategoryInAllegro = 101373;
                break;

            case 'music':
                $idCategoryInAllegro = 101359;
                break;

            default:
                $idCategoryInAllegro = null;
        }
        if ($idCategoryInAllegro) {
            $itemsId = $this->collectId($idCategoryInAllegro);
            $allItems = $this->getDetails($itemsId);
            print_r($allItems);
        }
        else {
            $allItems = [
                'error' => 'This category is not defined'
            ];
        }
        return $allItems;
    }

}
//
$zapytanie = new AllegroConnector();
$zapytanie->getItems('sport');

