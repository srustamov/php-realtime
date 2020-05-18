<?php


namespace App\Ws\Controllers;


use Ratchet\ConnectionInterface;
use SplObjectStorage;

abstract class Controller
{
    protected $clients;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->clients = new SplObjectStorage;
    }

    /**
     * @param ConnectionInterface $current
     * @param $message
     */
    public function broadcastAllWithoutCurrentUser(ConnectionInterface $current, $message)
    {
        foreach ($this->clients as $client) {
            if ($current !== $client) {
                $client->send($message);
            }
        }
    }


    /**
     * @param $message
     */
    public function broadcastAll($message)
    {
        foreach ($this->clients as $client) {
            $client->send($message);
        }
    }


    final public static function factory(...$args)
    {
        return new static(...$args);
    }
}
