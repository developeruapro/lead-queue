<?php
require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once('connection.php');

/**
 * @param AMQPMessage $message
 */
function process_message(AMQPMessage $message)
{
    echo "\n--------\n";
    echo $message->body;
    file_put_contents(__DIR__ .'/log.txt', "Time: " . date("Y-m-d H:i:s") . " " . $message->body . PHP_EOL, FILE_APPEND);
    sleep(2);
    echo "\n--------\n";

    $message->ack();

    // Send a message with the string "quit" to cancel the consumer.
    if ($message->body === 'quit') {
        $message->getChannel()->basic_cancel($message->getConsumerTag());
    }
}

$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');

/**
 * @param \PhpAmqpLib\Channel\AMQPChannel $channel
 * @param AbstractConnection $connection
 */
function shutdown($channel, $connection)
{
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

// Loop as long as the channel has callbacks registered
while ($channel->is_consuming()) {
    $channel->wait();
}