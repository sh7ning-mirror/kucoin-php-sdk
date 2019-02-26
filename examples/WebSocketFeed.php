<?php
include '../vendor/autoload.php';

use KuCoin\SDK\Auth;
use KuCoin\SDK\KuCoinApi;
use KuCoin\SDK\PrivateApi\WebSocketFeed;
use Ratchet\Client\WebSocket;
use React\EventLoop\LoopInterface;

// Set the base uri, default "https://openapi-v2.kucoin.com" for production environment.
// KuCoinApi::setBaseUri('https://openapi-v2.kucoin.com');

$auth = null;
// Need to pass parameters when subscribing to a private channel($api->subscribePrivateChannel()).
// $auth = new Auth('key', 'secret', 'passphrase');
$api = new WebSocketFeed($auth);

$query = ['connectId' => uniqid('', true)];
$channel = [
    'topic' => '/market/ticker:KCS-BTC',
    //'response' => true,
];

$api->subscribePublicChannel($query, $channel, function (array $message, WebSocket $ws, LoopInterface $loop) use ($api) {
    var_dump($message);
    // Stop loop
    // $loop->stop();
}, function ($code, $reason) {
    echo "OnClose: {$code} {$reason}\n";
});