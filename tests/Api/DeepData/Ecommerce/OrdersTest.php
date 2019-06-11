<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Api\DeepData\Ecommerce;

use Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce\Order as OrderApi;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\Order as OrderModel;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\Orders;
use Pixelperfect\ActiveCampaign\Tests\AbstractApi;

class OrdersTest extends AbstractApi
{

    /**
     * @dataProvider dataProviderRequestData
     */
    public function testCreateOrder($data)
    {
        $apiClient = $this->getApiClient();
        $orderData = OrderModel::createFromArray($data)->jsonSerialize();

        $response = $apiClient->deepDataEcommerceOrder()->create($orderData);
    }

    public function testGetOrder()
    {
        $this->fail(__METHOD__);
    }

    public function testUpdateOrder()
    {
        $this->fail(__METHOD__);
    }

    public function testDeleteOrder()
    {
        $this->fail(__METHOD__);
    }

    public function testListOrders()
    {
        $apiClient = $this->getApiClient();
        /** @var Orders $orders */
        $orders = $apiClient->deepDataEcommerceOrder()->list();
        $this->assertInstanceOf(Orders::class, $orders, 'Object is not instance of :' . Orders::class);
        $this->assertGreaterThan(0, $orders->count(), 'There are not enough orders');


    }

    public function dataProviderResponseData()
    {
        return [
            [
                [
                    'ecomOrder' => $this->dataProviderOrderInformation('ecomOrderProducts')
                ]
            ]

        ];
    }

    public function dataProviderRequestData()
    {
        return [
            [
                [
                    'ecomOrder' => $this->dataProviderOrderInformation('orderProducts')
                ]
            ]
        ];
    }

    public function dataProviderOrderInformation(string $orderProductsKey)
    {
        return [

            'externalid'      => 3246315233,
            'source'          => 1,
            'email'           => 'alice@example.com',
            'orderNumber'     => '1057',
            'orderUrl'        => 'https://example.com/orders/3246315233',
            'orderDate'       => '2016-09-13T17:41:39-04:00',
            'shippingMethod'  => 'POST AT',
            'totalPrice'      => 9111,
            'currency'        => 'EUR',
            'connectionid'    => 1,
            'customerid'      => 1,
            $orderProductsKey => $this->dataProviderProductArray()

        ];
    }

    private function dataProviderProductArray()
    {
        return [

            [
                'externalid' => 'PROD12345',
                "name"       => 'Pogo Stick',
                "price"      => 4900,
                "quantity"   => 1,
                "category"   => "Toys"
            ],
            [
                'externalid' => 'PROD23456',
                "name"       => 'Skateboard',
                "price"      => 3000,
                "quantity"   => 1,
                "category"   => "Toys"
            ]

        ];
    }
}
