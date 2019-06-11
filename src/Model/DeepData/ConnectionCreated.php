<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class ConnectionCreated
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData
 */
class ConnectionCreated implements CreatableFromArray
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * ConnectionCreated constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->setConnection($connection);
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     *
     * @return ConnectionCreated
     */
    public function setConnection(Connection $connection): ConnectionCreated
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Create an API response object from the HTTP response from the API server.
     *
     * @param array $data
     *
     * @return self
     */
    public static function createFromArray(array $data)
    {
        $connection = null;

        if (isset($data['connection'])) {
            $connection = Connection::createFromArray($data['connection']);
        }
        return new self($connection);
    }
}
