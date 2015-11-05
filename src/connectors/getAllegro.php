<?php
//require_once('../../allegro-trash/lib/nusoap.php');
//$soapClient = new nusoap_client('https://webapi.allegro.pl/service.php?wsdl', true);
//$result = $soapClient->call(
//    'doQueryAllSysStatus',
//    array(
//        array(
//            'countryId' => 1,
//            'webapiKey' => '99275d6f'
//        )
//    )
//);
//
//print_r($result);
$login = 'Ivone107';
$password = 'Kopcioland1';
$apikey = '99275d6f';
$options['features'] = SOAP_SINGLE_ELEMENT_ARRAYS;

$soapClient = new SoapClient('https://webapi.allegro.pl/service.php?wsdl', $options);

$request = [
    'countryId' => 1,
    'webapiKey' => $apikey
];

$status = $soapClient->doQueryAllSysStatus($request);
$apiVersion =  $status->sysCountryStatus->item[0]->verKey;

echo $apiVersion;

////print_r($status);
//
//$response = $soapClient->doLogin([
//    'userLogin' => $login,
//    'userPassword' => $password,
//    'countryCode' => 1,
//    'webapiKey' => $apikey,
//    'localVersion' => $apiVersion
//]);

//$sessionId = $response->sessionHandlePart;

//var_export($sessionId);

// 'categoryId' => 98553,
// 'categoryName' => 'Bilety',

$request = [
    'webapiKey' => $apikey,
    'countryId' => 1,
    'filterOptions' => [[
        'filterId' => 'category',
        'filterValueId' => ['98553']
    ]]
];

$status = $soapClient->DoGetItemsList($request);
print_r($status);