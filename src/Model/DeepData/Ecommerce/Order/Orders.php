<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\AbstractModelCollection;

/**
 * Class OrderProducts
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order
 */
class Orders extends AbstractModelCollection
{

    const DATA_OBJECT_KEY          = 'ecomOrders';

    /**
     * @return mixed
     */
    public static function getModelClassname()
    {
        return Order::class;
    }

    /**
     * @param array $data
     * @param       $dataKey
     *
     * @return bool
     */
    public static function isSetDataKey(array $data, $dataKey): bool
    {
        return parent::isSetDataKey($data, $dataKey) ?: parent::isSetDataKey($data, static::RESPONSE_DATA_OBJECT_KEY);
    }

    /**
     * @param $data
     *
     * @return string|null
     */
    public static function fetchDataKey($data)
    {
        if (array_key_exists(static::RESPONSE_DATA_OBJECT_KEY, $data)) {
            return static::RESPONSE_DATA_OBJECT_KEY;
        }
        return parent::fetchDataKey($data);
    }

    public function jsonSerialize()
    {
        $data = [];
        /** @var OrderProduct $item */
        foreach ($this->getItems() as $item) {
            $data[] = $item->jsonSerialize();
        }
        return $data;
    }

}
