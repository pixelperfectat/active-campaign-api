<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Unit\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderProduct;
use Pixelperfect\ActiveCampaign\Tests\Unit\TestCase;

class OrderProductTest extends TestCase
{

    /**
     * @dataProvider dataProviderCreateFromArray
     */
    public function testCreateFromArray(array $data)
    {
        $actual = OrderProduct::createFromArray($data);

        $this->assertInstanceOf(OrderProduct::class, $actual, 'Asserting instance of OrderProduct');
    }

    public function dataProviderCreateFromArray()
    {
        return [
            [
                [
                    'orderProducts' => [
                        'externalid' => 'PROD12345',
                        "name"       => 'Pogo Stick',
                        "price"      => 4900,
                        "quantity"   => 1,
                        "category"   => "Toys"
                    ]
                ]
            ]
        ];
    }
}
