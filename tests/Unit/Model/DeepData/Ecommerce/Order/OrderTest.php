<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Unit\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\Order;
use Pixelperfect\ActiveCampaign\Tests\Unit\TestCase;

/**
 * Class OrderTest
 *
 * @package Pixelperfect\ActiveCampaign\Tests\Unit\Model\DeepData\Ecommerce\Order
 */
class OrderTest extends TestCase
{

    /**
     * @dataProvider dataProviderRequestData
     */
    public function testCreateOrderObjectFromRequestData($data)
    {
        $this->createOrderObjectFromArray($data, 'orderProducts');
    }

    /**
     * @dataProvider dataProviderResponseData
     */
    public function testCreateOrderObjectFromResponseData($data)
    {
        $this->createOrderObjectFromArray($data, 'ecomOrderProducts');
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

    /**
     * @param $data
     */
    private function createOrderObjectFromArray($data, $dataKey): void
    {
        /** @var Order $order */
        $order = Order::createFromArray($data);

        $this->assertInstanceOf(Order::class, $order);

        // count compare the number of order items
        $orderProducts      = $order->getOrderProducts();
        if ($orderProducts) {
            $actualOrderItems   = $orderProducts->count();
            $expectedOrderItems = count($data['ecomOrder'][$dataKey]);
            $this->assertEquals($expectedOrderItems, $actualOrderItems, 'Order item count does not match');
        }
    }

}
