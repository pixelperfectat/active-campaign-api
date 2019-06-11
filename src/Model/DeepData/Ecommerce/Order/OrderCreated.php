<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class CustomerCreated
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order
 */
final class OrderCreated implements CreatableFromArray
{

    const DATA_KEY = 'ecomOrder';

    /**
     * @var Order
     */
    private $customer;

    /**
     * CustomerCreated constructor.
     *
     * @param Order $customer
     */
    public function __construct(Order $customer)
    {
        $this->setCustomer($customer);
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
        $data = '';
        if (isset($data[self::DATA_KEY])) {
            $data = Order::createFromArray($data[self::DATA_KEY]);
        }
        return new self($data);
    }

    /**
     * @return Order
     */
    public function getCustomer(): Order
    {
        return $this->customer;
    }

    /**
     * @param Order $customer
     */
    public function setCustomer(Order $customer): void
    {
        $this->customer = $customer;
    }
}
