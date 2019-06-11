<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model;

use DateTimeImmutable;
use Exception;
use JsonSerializable;
use ReflectionClass;

/**
 * Class AbstractModel
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
abstract class AbstractModel implements JsonSerializable, CreatableFromArray
{

    /**
     * AbstractModel constructor.
     *
     * @param array $data
     */
    abstract public function __construct(array $data);

    /**
     * Create an API response object from the HTTP response from the API server.
     *
     * @param array $data
     *
     * @return self
     */
    public static function createFromArray(array $data)
    {
        return new static($data);
    }

    public function jsonSerialize()
    {
        $class      = new ReflectionClass($this);
        $properties = $class->getProperties();
        $data       = [];
        foreach ($properties as $property) {
            $propertyName        = $property->getName();
            $propertyGetter      = 'get' . ucfirst($propertyName);
            $data[$propertyName] = $this->{$propertyGetter}();
        }
        return $data;
    }

    /**
     * @param $dateString
     *
     * @return DateTimeImmutable|null
     * @throws Exception
     */
    protected static function createDateObject($dateString)
    {
        return $dateString !== null ? new DateTimeImmutable($dateString) : $dateString;
    }
}
