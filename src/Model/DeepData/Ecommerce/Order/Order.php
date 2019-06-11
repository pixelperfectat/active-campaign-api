<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order;

use DateTime;
use DateTimeInterface;
use Exception;
use Pixelperfect\ActiveCampaign\Model\AbstractModel;

/**
 * Class Order
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order
 */
class Order extends AbstractModel
{

    const DATA_KEY = 'ecomOrder';

    /**
     * @var string
     */
    private $externalid;

    /**
     * @var int|null
     */
    private $source;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $totalPrice;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var int
     */
    private $connectionid;

    /**
     * @var int
     */
    private $customerid;

    /**
     * @var string|null
     */
    private $orderNumber;

    /**
     * @var string|null
     */
    private $orderUrl;

    /**
     * @var DateTimeInterface
     */
    private $orderDate;

    /**
     * @var string|null
     */
    private $shippingMethod;

    /**
     * @var OrderProducts
     */
    private $orderProducts;

    /**
     * @var int
     */
    private $state;

    /**
     * @var int|null
     */
    private $externalcheckoutid;

    /**
     * @var int
     */
    private $totalProducts;

    /**
     * @var DateTimeInterface
     */
    private $externalCreatedDate;

    /**
     * @var DateTimeInterface|null
     */
    private $externalUpdatedDate;

    /**
     * @var DateTimeInterface|null
     */
    private $abandonedDate;

    /**
     * @var DateTimeInterface
     */
    private $createdDate;

    /**
     * @var DateTimeInterface
     */
    private $updatedDate;

    /**
     * @var DateTimeInterface
     */
    private $tstamp;

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
    private $customer;

    /**
     * AbstractModel constructor.
     *
     * @param array $data
     *
     * @throws Exception
     */
    public function __construct(array $data)
    {
        if (array_key_exists(static::DATA_KEY, $data)) {
            $dataSource = $data[static::DATA_KEY];
        } else {
            $dataSource = $data;
        }
        $productsDataKey      = OrderProducts::fetchDataKey($dataSource);
        $dataContainsProducts = array_key_exists($productsDataKey, $dataSource);

        extract($dataSource);

        $this->setConnectionid((int)$connectionid)
            ->setCurrency((string)$currency)
            ->setCustomerid((int)$customerid)
            ->setEmail((string)$email)
            ->setExternalid((string)$externalid)
            ->setOrderDate(static::createDateObject($orderDate))
            ->setOrderNumber(isset($orderNumber) ? (string)$orderNumber : null)
            ->setOrderUrl(isset($orderUrl) ? (string)$orderUrl : null)
            ->setShippingMethod(isset($shippingMethod) ? (string)$shippingMethod : null)
            ->setSource(isset($source) ? (int)$source : null)
            ->setTotalPrice((int)$totalPrice);

        // optional properties set from response
        $this->setState((int)$state)
            ->setExternalcheckoutid(isset($state) ? (int)$state : null)
            ->setTotalProducts((int)$totalProducts)
            ->setExternalCreatedDate(static::createDateObject($externalCreatedDate))
            ->setExternalUpdatedDate(static::createDateObject($externalUpdatedDate))
            ->setAbandonedDate(static::createDateObject($abandonedDate))
            ->setCreatedDate(static::createDateObject($createdDate))
            ->setUpdatedDate(static::createDateObject($updatedDate))
            ->setTstamp(static::createDateObject($tstamp))
            ->setLinks($links ?: [])
            ->setId((int)$id)
            ->setConnection((int)$connection)
            ->setCustomer((int)$customer);;

        // products
        if ($dataContainsProducts) {
            $this->setOrderProducts(OrderProducts::createFromArray($dataSource));
        }
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     *
     * @return Order
     */
    public function setState(int $state): Order
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getExternalcheckoutid(): ?int
    {
        return $this->externalcheckoutid;
    }

    /**
     * @param int|null $externalcheckoutid
     *
     * @return Order
     */
    public function setExternalcheckoutid(?int $externalcheckoutid): Order
    {
        $this->externalcheckoutid = $externalcheckoutid;
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
     * @return Order
     */
    public function setTotalProducts(int $totalProducts): Order
    {
        $this->totalProducts = $totalProducts;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getExternalCreatedDate(): DateTimeInterface
    {
        return $this->externalCreatedDate;
    }

    /**
     * @param DateTimeInterface $externalCreatedDate
     *
     * @return Order
     */
    public function setExternalCreatedDate(DateTimeInterface $externalCreatedDate): Order
    {
        $this->externalCreatedDate = $externalCreatedDate;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getExternalUpdatedDate(): ?DateTimeInterface
    {
        return $this->externalUpdatedDate;
    }

    /**
     * @param DateTimeInterface|null $externalUpdatedDate
     *
     * @return Order
     */
    public function setExternalUpdatedDate(?DateTimeInterface $externalUpdatedDate): Order
    {
        $this->externalUpdatedDate = $externalUpdatedDate;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAbandonedDate(): ?DateTimeInterface
    {
        return $this->abandonedDate;
    }

    /**
     * @param DateTimeInterface|null $abandonedDate
     *
     * @return Order
     */
    public function setAbandonedDate(?DateTimeInterface $abandonedDate): Order
    {
        $this->abandonedDate = $abandonedDate;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedDate(): DateTimeInterface
    {
        return $this->createdDate;
    }

    /**
     * @param DateTimeInterface $createdDate
     *
     * @return Order
     */
    public function setCreatedDate(DateTimeInterface $createdDate): Order
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedDate(): DateTimeInterface
    {
        return $this->updatedDate;
    }

    /**
     * @param DateTimeInterface $updatedDate
     *
     * @return Order
     */
    public function setUpdatedDate(DateTimeInterface $updatedDate): Order
    {
        $this->updatedDate = $updatedDate;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTstamp(): DateTimeInterface
    {
        return $this->tstamp;
    }

    /**
     * @param DateTimeInterface $tstamp
     *
     * @return Order
     */
    public function setTstamp(DateTimeInterface $tstamp): Order
    {
        $this->tstamp = $tstamp;
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
     * @return Order
     */
    public function setLinks(array $links): Order
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
     * @return Order
     */
    public function setId(int $id): Order
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
     * @return Order
     */
    public function setConnection(int $connection): Order
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomer(): int
    {
        return $this->customer;
    }

    /**
     * @param int $customer
     *
     * @return Order
     */
    public function setCustomer(int $customer): Order
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalid(): string
    {
        return $this->externalid;
    }

    /**
     * @param string $externalid
     *
     * @return Order
     */
    public function setExternalid(string $externalid): Order
    {
        $this->externalid = $externalid;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSource(): int
    {
        return $this->source;
    }

    /**
     * @param int|null $source
     *
     * @return Order
     */
    public function setSource(int $source): Order
    {
        $this->source = $source;
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
     * @return Order
     */
    public function setEmail(string $email): Order
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     *
     * @return Order
     */
    public function setTotalPrice(int $totalPrice): Order
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Order
     */
    public function setCurrency(string $currency): Order
    {
        $this->currency = $currency;
        return $this;
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
     * @return Order
     */
    public function setConnectionid(int $connectionid): Order
    {
        $this->connectionid = $connectionid;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerid(): int
    {
        return $this->customerid;
    }

    /**
     * @param int $customerid
     *
     * @return Order
     */
    public function setCustomerid(int $customerid): Order
    {
        $this->customerid = $customerid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string|null $orderNumber
     *
     * @return Order
     */
    public function setOrderNumber(string $orderNumber): Order
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderUrl(): string
    {
        return $this->orderUrl;
    }

    /**
     * @param string|null $orderUrl
     *
     * @return Order
     */
    public function setOrderUrl(string $orderUrl): Order
    {
        $this->orderUrl = $orderUrl;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getOrderDate(): DateTimeInterface
    {
        return $this->orderDate;
    }

    /**
     * @param DateTimeInterface $orderDate
     *
     * @return Order
     */
    public function setOrderDate(DateTimeInterface $orderDate): Order
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingMethod(): string
    {
        return $this->shippingMethod;
    }

    /**
     * @param string|null $shippingMethod
     *
     * @return Order
     */
    public function setShippingMethod(string $shippingMethod): Order
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }

    /**
     * @return OrderProducts
     */
    public function getOrderProducts(): ?OrderProducts
    {
        return $this->orderProducts;
    }

    /**
     * @param OrderProducts $orderProducts
     *
     * @return Order
     */
    public function setOrderProducts(?OrderProducts $orderProducts): Order
    {
        $this->orderProducts = $orderProducts;
        return $this;
    }

    public function jsonSerialize()
    {
        $data              = parent::jsonSerialize();
        $data['orderDate'] = $this->getOrderDate()->format(DateTime::ISO8601);
        $orderProducts     = $this->getOrderProducts();
        if ($orderProducts) {
            $data['orderProducts'] = $this->getOrderProducts()->jsonSerialize();
        }

        return $data;
    }

}
