<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model;

/**
 * Class AbstractModelUpdated
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
class AbstractModelUpdated implements CreatableFromArray
{

    /**
     * @var string
     */
    public static $dataKey = 'dataKey';

    /**
     * @var AbstractModel
     */
    protected static $entity;

    /**
     * CustomerCreated constructor.
     *
     * @param AbstractModel $entity
     */
    public function __construct(AbstractModel $entity)
    {
        static::setEntity($entity);
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
        if (isset($data[static::getDataKey()])) {
            $entityClassName = str_replace("Updated", null, static::class);
            $entity          = $entityClassName::createFromArray($data[static::getDataKey()]);
        }
        return new static($entity);
    }

    /**
     * @return string
     */
    public static function getDataKey(): string
    {
        return static::$dataKey;
    }

    /**
     * @param string $dataKey
     */
    public static function setDataKey(string $dataKey): void
    {
        static::$dataKey = $dataKey;
    }

    /**
     * @return AbstractModel
     */
    public static function getEntity(): AbstractModel
    {
        return static::$entity;
    }

    /**
     * @param AbstractModel $entity
     */
    public function setEntity(AbstractModel $entity): void
    {
        static::$entity = $entity;
    }
}
