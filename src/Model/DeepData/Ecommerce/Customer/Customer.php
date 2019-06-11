<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer;

use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class Customer
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer
 */
final class Customer extends AbstractModel implements CreatableFromArray
{

    /**
     * @var int
     */
    private $connectionid;

    /**
     * @var int
     */
    private $externalid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var array
     */
    private $links;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $connection;

    /**
     * @var int
     */
    private $totalRevenue;

    /**
     * @var int
     */
    private $totalOrders;

    /**
     * @var int
     */
    private $avgRevenuePerOrder;

    /**
     * @var string
     */
    private $avgProductCategory;

    /**
     * @var bool
     */
    private $acceptsMarketing;

    /**
     * @var int
     */
    private $totalProducts;

    /**
     * Customer constructor.
     *
     * @param $data
     */
    public function __construct(array $data)
    {
        $dataSource = null;
        if (array_key_exists('ecomCustomer', $data)) {
            $dataSource = $data['ecomCustomer'];
        } else {
            $dataSource = $data;
        }
        extract($dataSource);

        $this->setId((int)$id)
            ->setConnection((int)$connection)
            ->setLinks($links)
            ->setEmail($email)
            ->setConnectionid((int)$connectionid)
            ->setExternalid((int)$externalid)
            ->setTotalRevenue(isset($totalRevenue) ? (int)$totalRevenue : null)
            ->setTotalOrders(isset($totalOrders) ? (int)$totalOrders : null)
            ->setAvgRevenuePerOrder(isset($avgRevenuePerOrder) ? (int)$avgRevenuePerOrder : null)
            ->setAvgProductCategory(isset($avgProductCategory) ? $avgProductCategory : null)
            ->setAcceptsMarketing(isset($acceptsMarketing) ? (bool)$acceptsMarketing : false);
    }

    /**
     * @return int
     */
    public function getConnectionid(): int
    {
        return $this->connectionid;
    }

    /**
     * @param int $connectionid
     *
     * @return Customer
     */
    public function setConnectionid(int $connectionid): Customer
    {
        $this->connectionid = $connectionid;
        return $this;
    }

    /**
     * @return int
     */
    public function getExternalid(): int
    {
        return $this->externalid;
    }

    /**
     * @param int $externalid
     *
     * @return Customer
     */
    public function setExternalid(int $externalid): Customer
    {
        $this->externalid = $externalid;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return Customer
     */
    public function setLinks(array $links): Customer
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Customer
     */
    public function setId(int $id): Customer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getConnection(): int
    {
        return $this->connection;
    }

    /**
     * @param int $connection
     *
     * @return Customer
     */
    public function setConnection(int $connection): Customer
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalRevenue(): int
    {
        return $this->totalRevenue;
    }

    /**
     * @param int $totalRevenue
     *
     * @return Customer
     */
    public function setTotalRevenue(?int $totalRevenue): Customer
    {
        $this->totalRevenue = $totalRevenue;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalOrders(): int
    {
        return $this->totalOrders;
    }

    /**
     * @param int $totalOrders
     *
     * @return Customer
     */
    public function setTotalOrders(?int $totalOrders): Customer
    {
        $this->totalOrders = $totalOrders;
        return $this;
    }

    /**
     * @return int
     */
    public function getAvgRevenuePerOrder(): int
    {
        return $this->avgRevenuePerOrder;
    }

    /**
     * @param int $avgRevenuePerOrder
     *
     * @return Customer
     */
    public function setAvgRevenuePerOrder(?int $avgRevenuePerOrder): Customer
    {
        $this->avgRevenuePerOrder = $avgRevenuePerOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvgProductCategory(): string
    {
        return $this->avgProductCategory;
    }

    /**
     * @param string $avgProductCategory
     *
     * @return Customer
     */
    public function setAvgProductCategory(?string $avgProductCategory): Customer
    {
        $this->avgProductCategory = $avgProductCategory;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAcceptsMarketing(): bool
    {
        return $this->acceptsMarketing;
    }

    /**
     * @param bool $acceptsMarketing
     *
     * @return Customer
     */
    public function setAcceptsMarketing(bool $acceptsMarketing): Customer
    {
        $this->acceptsMarketing = $acceptsMarketing;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalProducts(): int
    {
        return $this->totalProducts;
    }

    /**
     * @param int $totalProducts
     *
     * @return Customer
     */
    public function setTotalProducts(int $totalProducts): Customer
    {
        $this->totalProducts = $totalProducts;
        return $this;
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
        return new self($data);
    }
}
