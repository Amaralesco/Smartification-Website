<?php

//require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

$clientId = 'test-subscriber';
$server   = 'broker.hivemq.com';
$port     = 1883;

use \PhpMqtt\Client\ConnectionSettings;

//CONNECTION
/* $connectionSettings  = new ConnectionSettings();
$connectionSettings
  ->setUsername($username)
  ->setPassword(null)
  ->setKeepAliveInterval(60)
  ->setLastWillMessage('client disconnect')
  ->setLastWillQualityOfService(1); */
//->setLastWillTopic('emqx/test/last-will')


  //SUBSCRIPTION
$mqtt = new \PhpMqtt\Client\MQTTClient($server, $port, $clientId);
//$mqtt->connect($connectionSettings);

// Connect to the broker without specific connection settings but with a clean session.
$mqtt->connect(null, true);

$mqtt->subscribe('jdSi72J29da/#', function ($topic, $message) {
    echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);
$mqtt->loop(true);

?>