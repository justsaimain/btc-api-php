<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

header('Content-type: application/json');

$client = new Client([
    'base_uri' => 'https://production.api.coindesk.com/',
]);

$response = $client->request('GET', '/v2/tb/price/ticker', [
    'query' => ['assets' => 'BTC']
]);

$arr_data = json_decode($response->getBody(), true);

if ($arr_data['statusCode'] === 200) {
    $c = number_format($arr_data["data"]['BTC']['ohlc']['c'], 2);
    $percent =number_format($arr_data["data"]['BTC']['change']['percent'], 2);

    $return_data = [
        'c' => $c,
        'percent' => substr($percent, 1),
        'c1' => substr($c, -1),
        'percent1' =>  substr($percent, -1),
    ];
} else {
    $return_data = [
        'error' => true,
        'message' => 'Something was wrong from Coindesk API'
    ];
}

echo json_encode($return_data);
