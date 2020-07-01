<?php

namespace Supervisor\Connector;

use Laminas\XmlRpc\Client;
use Laminas\XmlRpc\Client\Exception\FaultException;
use Supervisor\Connector;
use Supervisor\Exception\Fault;

/**
 * Uses Laminas XML-RPC.
 *
 * There are known and tested performance issues with it
 *
 * @see https://github.com/lstrojny/fxmlrpc#how-fast-is-it-really
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Laminas implements Connector
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function call($namespace, $method, array $arguments = [])
    {
        try {
            return $this->client->call($namespace . '.' . $method, $arguments);
        } catch (FaultException $e) {
            throw Fault::create($e->getMessage(), $e->getCode());
        }
    }
}
