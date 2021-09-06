<?php
require_once __DIR__.'/vendor/autoload.php';

use LeadGenerator\Lead;
use LeadGenerator\Generator;
use PhpAmqpLib\Message\AMQPMessage;

require_once('connection.php');

$generator = new Generator();
$generator->generateLeads(10000, function (Lead $lead) use ($channel, $exchange) {
    $properties = array('content_type' => 'text/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT);
    $msg = new AMQPMessage(json_encode($lead), $properties);
    $channel->basic_publish($msg, $exchange);
});

$channel->close();
$connection->close();

