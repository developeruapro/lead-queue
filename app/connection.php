<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

require_once __DIR__.'/vendor/autoload.php';

$connection = AMQPStreamConnection::create_connection([
    ['host' => 'rabbitmq', 'port' => 5672, 'user' => 'user', 'password' => 'pass', 'vhost' => '/'],
], []);

$queue = 'leads';
$exchange = 'router';
$consumerTag = 'consumer';
$channel = $connection->channel();

$channel->queue_declare($queue, false, true, false, false);
$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
$channel->queue_bind($queue, $exchange);