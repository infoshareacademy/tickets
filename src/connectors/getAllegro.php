<?php
require_once('../../allegro-trash/lib/nusoap.php');
$soapClient = new nusoap_client('https://webapi.allegro.pl/service.php?wsdl', true);
$result = $soapClient->call(
    'doQueryAllSysStatus',
    array(
        array(
            'countryId' => 1,
            'webapiKey' => '99275d6f'
        )
    )
);

print_r($result);