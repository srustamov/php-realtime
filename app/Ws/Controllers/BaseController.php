<?php

namespace App\Ws\Controllers;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class BaseController extends Controller implements MessageComponentInterface
{
    /**
     * @param ConnectionInterface $from
     * @param string $message
     */
    public function onMessage(ConnectionInterface $from, $message)
    {
        $this->broadcastAllWithoutCurrentUser($from,$message);
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
        $this->clients->attach($connection);
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->clients->detach($connection);
    }

    /**
     * @param ConnectionInterface $connection
     * @param Exception $e
     */
    public function onError(ConnectionInterface $connection, Exception $e)
    {
        $connection->close();
    }

}