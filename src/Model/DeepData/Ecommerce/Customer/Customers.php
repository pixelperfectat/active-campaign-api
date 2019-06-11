<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer;

use Pixelperfect\ActiveCampaign\Model\AbstractModelCollection;

/**
 * Class Customers
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer
 */
final class Customers extends AbstractModelCollection
{

    const DATA_OBJECT_KEY = 'ecomCustomers';

    /**
     * @return mixed
     */
    public static function getModelClassname()
    {
        return Customer::class;
    }
}
