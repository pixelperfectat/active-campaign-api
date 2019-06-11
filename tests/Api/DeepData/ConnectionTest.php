<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\tests\Api\DeepData;

use PHPUnit_Framework_TestCase;
use Pixelperfect\ActiveCampaign\Exception\Domain\NotFoundException;
use Pixelperfect\ActiveCampaign\Model\DeepData\Connection;
use Pixelperfect\ActiveCampaign\Model\DeepData\ConnectionCreated;
use Pixelperfect\ActiveCampaign\Model\DeepData\ConnectionDeleted;
use Pixelperfect\ActiveCampaign\Model\DeepData\Connections;
use Pixelperfect\ActiveCampaign\Tests\AbstractApi;

class ConnectionTest extends AbstractApi
{

    public function testCreate()
    {
        $apiClient = $this->getApiClient();
        $data      = [
            'service'    => 'magento',
            'externalid' => 'kdb_shop',
            'name'       => 'Kaufhaus Der Berge',
            'logoUrl'    => 'https://www.kaufhausderberge.at/media/logo/websites/5/kdb-logo.svg',
            'linkUrl'    => 'https://www.kaufhausderberge.at',
        ];
        /** @var ConnectionCreated $connectionCreated */
        $connectionCreated = $apiClient->deepDataConnection()->create($data);

        $this->assertInstanceOf(ConnectionCreated::class, $connectionCreated);
        $connection = $connectionCreated->getConnection();

        $this->assertInstanceOf(Connection::class, $connectionCreated->getConnection());

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $connection->{'get' . ucfirst($key)}());
        }
    }

    public function testDeleteSuccess()
    {
        $apiClient = $this->getApiClient();
        $id        = 2;
        /** @var ConnectionDeleted $connectionDeleted */
        $connectionDeleted = $apiClient->deepDataConnection()->delete($id);

        $this->assertEquals(true, $connectionDeleted->isDeleted());
    }

    public function testDeleteFailure()
    {
        $apiClient = $this->getApiClient();
        $id        = 1;

        try {
            /** @var ConnectionDeleted $connectionDeleted */
            $connectionDeleted = $apiClient->deepDataConnection()->delete($id);
        } catch (NotFoundException $e) {
            $this->assertEquals(true, true);
        }
    }

    public function testListConnections()
    {
        $apiClient = $this->getApiClient();

        $connections = $apiClient->deepDataConnection()->list();
    }

    public function testListConnectionsFilterExistingService()
    {
        $apiClient = $this->getApiClient();

        /** @var Connections $connections */
        $connections = $apiClient->deepDataConnection()->list('magento');

        $total = (int)$connections->getMeta()->total;
        $this->assertEquals(1, $total);
    }

    public function testListConnectionsFilterNonExistingService()
    {
        $apiClient = $this->getApiClient();

        $connections = $apiClient->deepDataConnection()->list('somecrap');
        $total       = (int)$connections->getMeta()->total;
        $this->assertEquals(0, $total);
    }
}
