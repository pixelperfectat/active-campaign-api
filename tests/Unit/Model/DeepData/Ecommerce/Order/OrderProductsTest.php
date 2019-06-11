<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Unit\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderProduct;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderProducts as OrderProductsCollection;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderProducts;
use Pixelperfect\ActiveCampaign\Tests\Unit\TestCase;

/**
 * Class OrderProducts
 *
 * @package Pixelperfect\ActiveCampaign\Tests\Unit\Model\DeepData\Ecommerce\Order
 */
class OrderProductsTest extends TestCase
{

    /**
     * @dataProvider dataProviderIsSetDataKey
     *
     * @param array  $dataArray
     * @param string $dataKey
     * @param bool   $expected
     */
    public function testIsSetDataKey(array $dataArray, string $dataKey, bool $expected)
    {
        $actual = OrderProductsCollection::isSetDataKey($dataArray, $dataKey);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider dataProviderOrderProductsFromRequest
     *
     * @param array $data
     */
    public function testCreateOrderProductsFromRequest(array $data)
    {
        $this->createCollectionFromDataArray($data, 'orderProducts');
    }

    /**
     * @dataProvider dataProviderOrderProductsFromResponse
     *
     * @param array $data
     */
    public function testCreateOrderProductsFromResponse(array $data)
    {
        $this->createCollectionFromDataArray($data, 'ecomOrderProducts');
    }

    public function dataProviderIsSetDataKey()
    {
        return [
            [
                ['orderProducts' => []],
                'orderProducts',
                true,
            ],
            [
                ['ecomOrderProducts' => []],
                'ecomOrderProducts',
                true,
            ],
            [
                ['nope' => []],
                'ecomOrderProducts',
                false,
            ],
        ];
    }

    public function dataProviderOrderProductsFromRequest()
    {
        return [
            [
                [
                    'orderProducts' => $this->dataProviderProductArray()
                ]
            ]
        ];
    }

    public function dataProviderOrderProductsFromResponse()
    {
        return [
            [
                [
                    'ecomOrderProducts' => $this->dataProviderProductArray()
                ]
            ]
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
     * @param array  $data
     * @param string $key
     */
    private function createCollectionFromDataArray(array $data, string $key): void
    {
        $collection    = OrderProducts::createFromArray($data);
        $count         = $collection->count();
        $expectedCount = count($data[$key]);

        $this->assertInstanceOf(OrderProducts::class, $collection, 'Order collection is correct Class');
        $this->assertEquals($expectedCount, $count, 'Correct number of items in collection');
    }

}
