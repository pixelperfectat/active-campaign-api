<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Entity;

use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\Customer;

class EntityModified
{

    /**
     * @var string
     */
    public static $dataKey = 'dataKey';

    /**
     * @var AbstractModel
     */
    private $entity;

    /**
     * CustomerCreated constructor.
     *
     * @param AbstractModel $entity
     */
    public function __construct(AbstractModel $entity)
    {
        $this->setEntity($entity);
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
        $entity = '';
        if (isset($data['ecomCustomer'])) {
            $entity = Customer::createFromArray($data[static::getDataKey()]);
        }
        return new self($entity);
    }

    /**
     * @return string
     */
    public static function getDataKey(): string
    {
        return self::$dataKey;
    }

    /**
     * @param string $dataKey
     */
    public static function setDataKey(string $dataKey): void
    {
        self::$dataKey = $dataKey;
    }

    /**
     * @return Customer
     */
    public function getEntity(): Customer
    {
        return $this->entity;
    }

    /**
     * @param Customer $entity
     */
    public function setEntity(Customer $entity): void
    {
        $this->entity = $entity;
    }
}
