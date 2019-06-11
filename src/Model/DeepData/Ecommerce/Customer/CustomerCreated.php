<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class CustomerCreated
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer
 */
final class CustomerCreated implements CreatableFromArray
{

    /**
     * @var Customer
     */
    private $customer;

    /**
     * CustomerCreated constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
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
        $customer = '';
        if (isset($data['ecomCustomer'])) {
            $customer = Customer::createFromArray($data['ecomCustomer']);
        }
        return new self($customer);
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }
}
