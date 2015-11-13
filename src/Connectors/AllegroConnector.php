<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.11.15
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

    public function __construct($client = null)
    {
        if($client) {
            $this->client = $client;
        } else {
            try {
                $options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;
                $this->client = new \SoapClient(self::APIURL, $options);
            }
            catch (\SoapFault $error) {
                $this->setError($error->faultcode, $error->faultstring);
            }
        }
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
            $this->setError($error->faultcode, $error->faultstring);
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
            $this->setError($error->faultcode, $error->faultstring);
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

        try {
            $itemList = $this->client->doGetItemsList($request);
            $list = $itemList->itemsList->item;
        }
        catch (\SoapFault $error) {

            $this->setError($error->faultcode, $error->faultstring);
            $list = [];
        }
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
            'getDesc' => 1,
            'itemsIdArray' => $tableId
        ];
        try {
            $response = $this->client->doGetItemsInfo($request);
        }
        catch (\SoapFault $error) {
            $this->setError($error->faultcode, $error->faultstring);
            $response = [];
        }
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

    private function setError($errorFromAllegro, $description) {
        throw new \ErrorException('Error '. $errorFromAllegro . ': '. $description);
    }

    public function getItems($category) {
        switch ($category) {
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
        }
        else {
            $this->setError('category', 'Wrong parametr in getItems');
        }

        return $allItems;

    }

}


