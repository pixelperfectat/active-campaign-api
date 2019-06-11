<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model;

use ArrayAccess;
use Countable;
use Iterator;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use stdClass;

/**
 * Class AbstractModelCollection
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
abstract class AbstractModelCollection extends AbstractModel
    implements CreatableFromArray, Countable, Iterator, ArrayAccess
{

    const DATA_OBJECT_KEY          = null;
    const RESPONSE_DATA_OBJECT_KEY = null;

    /**
     * @var CreatableFromArray[]
     */
    private $items;

    /**
     * @var stdClass
     */
    private $meta;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * Connections constructor.
     *
     * @param stdClass $meta
     * @param array    $items
     */
    public function __construct(array $items, stdClass $meta = null)
    {
        $modelClassName = static::getModelClassname();
        foreach ($items as $item) {
            if (!$item instanceof $modelClassName) {
                throw new InvalidArgumentException('All Items must be an instance of ' . $modelClassName);
            }
        }

        $this->meta  = $meta;
        $this->items = $items;
    }

    /**
     * @return CreatableFromArray[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return CreatableFromArray
     */
    public function getFirstItem()
    {
        reset($this->items);
        return current($this->items);
    }

    /**
     * @return stdClass
     */
    public function getMeta(): stdClass
    {
        return $this->meta;
    }

    /**
     * Create an API response object from the HTTP response from the API server.
     *
     * @param array $data
     *
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        $meta    = null;
        $items   = [];
        $class   = static::getModelClassname();
        $dataKey = static::fetchDataKey($data);

        if (static::isSetDataKey($data, $dataKey)) {
            foreach ($data[$dataKey] as $item) {
                if (is_subclass_of($class, CreatableFromArray::class)) {
                    $object = call_user_func($class . '::createFromArray', $item);
                } else {
                    $object = new $class($item);
                }
                $items[] = $object;
            }
        }

        if (isset($data['meta'])) {
            $meta = (object)$data['meta'];
        }

        return new static($items, $meta);
    }

    /**
     * @return mixed
     */
    abstract public static function getModelClassname();

    /**
     * @param array $data
     * @param       $dataKey
     *
     * @return bool
     */
    public static function isSetDataKey(array $data, $dataKey): bool
    {
        return array_key_exists($dataKey, $data);
    }

    /**
     * Implementation of method declared in \Countable.
     *
     * Provides support for count()
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Implementation of method declared in \Iterator
     *
     * Resets the internal cursor to the beginning of the array
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Implementation of method declared in \Iterator
     *
     * Used to get the current key (as for instance in a foreach()-structure
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Implementation of method declared in \Iterator
     *
     * Used to get the value at the current cursor position
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * Implementation of method declared in \Iterator
     *
     * Used to move the cursor to the next position
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Implementation of method declared in \Iterator
     *
     * Checks if the current cursor position is valid
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Implementation of method declared in \ArrayAccess
     *
     * Used to be able to use functions like isset()
     *
     * @param $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Implementation of method declared in \ArrayAccess
     *
     * Used for direct access array-like ($collection[$offset]);
     *
     * @param $offset
     *
     * @return mixed|CreatableFromArray
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Implementation of method declared in \ArrayAccess
     *
     * Used for direct setting of values
     *
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException("Must be an int");
        }

        if (empty($offset)) { //this happens when you do $collection[] = 1;
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Implementation of method declared in \ArrayAccess
     *
     * Used for unset()
     *
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @param $data
     *
     * @return |null
     */
    public static function fetchDataKey($data)
    {
        return static::getDataKey();
    }

    /**
     * @return |null
     */
    private static function getDataKey()
    {
        return static::DATA_OBJECT_KEY;
    }

}
