<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order;

use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class OrderProduct
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order
 */
final class OrderProduct extends AbstractModel implements CreatableFromArray
{

    const DATA_KEY = 'orderProducts';

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string|null
     */
    private $externalid;

    /**
     * @var string|null
     */
    private $category;

    /**
     * AbstractModel constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $dataSource = null;
        if (array_key_exists(static::DATA_KEY, $data)) {
            $dataSource = $data[static::DATA_KEY];
        } else {
            $dataSource = $data;
        }
        extract($dataSource);

        $this->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
            ->setExternalid($externalid ?? null)
            ->setCategory($category ?? null);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return OrderProduct
     */
    public function setName(string $name): OrderProduct
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     *
     * @return OrderProduct
     */
    public function setPrice(int $price): OrderProduct
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return OrderProduct
     */
    public function setQuantity(int $quantity): OrderProduct
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalid(): string
    {
        return $this->externalid;
    }

    /**
     * @param string|null $externalid
     *
     * @return OrderProduct
     */
    public function setExternalid(?string $externalid): OrderProduct
    {
        $this->externalid = $externalid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     *
     * @return OrderProduct
     */
    public function setCategory(?string $category): OrderProduct
    {
        $this->category = $category;
        return $this;
    }
}
