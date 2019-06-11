<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Api\DeepData;

use Pixelperfect\ActiveCampaign\ApiClient;
use Pixelperfect\ActiveCampaign\Exception;
use Pixelperfect\ActiveCampaign\Exception\DomainException;
use Pixelperfect\ActiveCampaign\Model\DeepData\Connection;
use Pixelperfect\ActiveCampaign\Model\DeepData\Connections;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\Customer;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\Customers;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\CustomerUpdated;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetDeleted;
use Pixelperfect\ActiveCampaign\Tests\AbstractApi;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CustomerTest
 *
 * @package Pixelperfect\ActiveCampaign\tests\Api\DeepData
 */
class CustomerTest extends AbstractApi
{

    public function testCreateCustomer()
    {
        $id = $this->createCustomer();
        $this->assertNotNull($id);
        //$this->deleteCustomerById($id);
    }

    public function testListCustomersByConnectionId()
    {
        $apiClient    = $this->getApiClient();
        $connectionId = $this->getMagentoConnectionId();

        /** @var Customers $customerCollection */
        $customerCollection = $apiClient->deepDataEcommerceCustomer()->list(null, null, $connectionId);

        $customer = $customerCollection->getItems()[0];

        $total = (int)$customerCollection->getMeta()->total;

        $this->assertEquals(1, $total);
    }

    public function testListCustomersFilterWithExistingEmail()
    {
        $apiClient    = $this->getApiClient();
        $connectionId = $this->getMagentoConnectionId();

        $email              = 'test@somedomain.com';
        $customerCollection = $this->findCustomerByEmailAndConnection($apiClient, $email, $connectionId);

        $customer = $customerCollection->getItems()[0];

        $total = (int)$customerCollection->getMeta()->total;

        $this->assertEquals(1, $total);
    }

    public function testDeleteCustomer()
    {
        $apiClient          = $this->getApiClient();
        $connectionId       = $this->getMagentoConnectionId();
        $email              = 'test@somedomain.com';
        $customerCollection = $this->findCustomerByEmailAndConnection($apiClient, $email, $connectionId);

        $customer = $customerCollection->getItems()[0];

        $ecommerceCustomer = $apiClient->deepDataEcommerceCustomer()->delete($customer->getId());
    }

    public function testGetCustomer()
    {
        $apiClient         = $this->getApiClient();
        $id                = $this->createCustomer();
        $ecommerceCustomer = $apiClient->deepDataEcommerceCustomer()->get($id);
    }

    public function testUpdateCustomerAcceptsMarketing()
    {
        $apiClient    = $this->getApiClient();
        $email        = 'test@somedomain.com';
        $connectionId = $this->getMagentoConnectionId();

        $customers = $this->findCustomerByEmailAndConnection(
            $apiClient, $email, $connectionId
        );

        /** @var Customer $customer */
        $customer = $customers->getFirstItem();

        /** @var CustomerUpdated $customerUpdated */
        $customerUpdated = $apiClient->deepDataEcommerceCustomer()->update(
            $customer->getId(),
            null,
            $connectionId,
            null,
            true
        );

        $customer = $customerUpdated::getEntity();

        $this->assertTrue($customer->isAcceptsMarketing());
    }

    /**
     * @return int
     */
    private function getMagentoConnectionId(): int
    {
        $apiClient = $this->getApiClient();

        /** @var Connections $connectionCollection */
        $connectionCollection = $apiClient->deepDataConnection()->list('magento');

        /** @var Connection $connection */
        $connection   = $connectionCollection->getItems()[0];
        $connectionId = $connection->getId();
        return $connectionId;
    }

    /**
     * @param ApiClient $apiClient
     * @param string    $email
     * @param int       $connectionId
     *
     * @return Customers
     * @throws DomainException
     */
    private function findCustomerByEmailAndConnection(ApiClient $apiClient, string $email, int $connectionId): Customers
    {
        /** @var Customers $customerCollection */
        $customerCollection = $apiClient->deepDataEcommerceCustomer()->list($email, null, $connectionId);
        return $customerCollection;
    }

    /**
     * @param bool $acceptsMarketing
     *
     * @return int
     * @throws DomainException
     */
    private function createCustomer(bool $acceptsMarketing = false): int
    {
        $apiClient    = $this->getApiClient();
        $connectionId = $this->getMagentoConnectionId();

        $data = [
            'connectionid'     => $connectionId,
            'externalid'       => 'MAGE_CUSTOMER-001',
            'email'            => 'test@somedomain.com',
            'acceptsMarketing' => (int)$acceptsMarketing
        ];

        $ecommerceCustomer = $apiClient->deepDataEcommerceCustomer()->create($data);
        return $ecommerceCustomer->getCustomer()->getId();
    }

    /**
     * @param int $id
     *
     * @return TweetDeleted|ResponseInterface
     * @throws Exception
     */
    private function deleteCustomerById(int $id)
    {
        $apiClient = $this->getApiClient();
        return $apiClient->deepDataEcommerceCustomer()->delete($id);
    }
}
