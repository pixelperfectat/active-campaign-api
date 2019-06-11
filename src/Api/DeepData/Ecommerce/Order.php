<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce;

use Pixelperfect\ActiveCampaign\Api\HttpApi;
use Pixelperfect\ActiveCampaign\Api\ServiceInterface;
use Pixelperfect\ActiveCampaign\Exception;
use Pixelperfect\ActiveCampaign\Exception\DomainException;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\Order as OrderModel;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderCreated;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderDeleted;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\Orders;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Order\OrderUpdated;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetUpdated;
use Pixelperfect\ActiveCampaign\Validator\DeepData\Ecommerce\Order as OrderValidator;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Order
 *
 * @package Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce
 */
final class Order extends HttpApi implements ServiceInterface
{

    const ROUTE = '/api/3/ecomOrders';

    /**
     * @param array $data
     *
     * @return OrderCreated
     * @throws DomainException
     */
    public function create(array $data): OrderCreated
    {
//        $requiredParams = ['connectionid', 'externalid', 'email', 'acceptsMarketing'];
//        $this->validateRequiredParams($data, $requiredParams);
        try {
            $orderValidator = new OrderValidator();
            $orderValidator->validateParams($data);

            $params['ecomOrder'] = $data;

            $response = $this->httpPost(self::ROUTE, $params);

            if (!$this->hydrator) {
                return $response;
            }

            $allowedResponseCodes = [200, 201];

            // Use any valid status code here
            if (!in_array($response->getStatusCode(), $allowedResponseCodes)) {
                switch ($response->getStatusCode()) {
                    default:
                        $this->handleErrors($response);
                        break;
                }
            }

            return $this->hydrator->hydrate($response, OrderCreated::class);
        } catch (\InvalidArgumentException $e) {
            // log invalid arguments
        } catch (\Http\Client\Exception $e) {
            // log error in http
        }
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function get(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpGet(sprintf(self::ROUTE . '/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, OrderModel::class);
    }

    /**
     *
     * @param string|null $email
     * @param string|null $externalid
     * @param string|null $connectionid
     *
     * @return mixed
     * @throws DomainException
     */
    public function list(string $email = null, string $externalid = null, int $connectionid = null)
    {
        $filters                 = [];
        $filters['email']        = $email;
        $filters['externalid']   = $externalid;
        $filters['connectionid'] = $connectionid;

        $filters = array_filter($filters);
        $params  = [];
        if (count($filters) > 0) {
            $params['filters'] = $filters;
        }

        $response = $this->httpGet('' . self::ROUTE . '', $params);

        if (!$this->hydrator) {
            return $response;
        }

        $allowedResponseCodes = [200];

        // Use any valid status code here
        if (!in_array($response->getStatusCode(), $allowedResponseCodes)) {
            switch ($response->getStatusCode()) {
                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, Orders::class);
    }

    /**
     * @param int         $id
     * @param int|null    $externalid
     * @param int|null    $connectionid
     * @param string|null $email
     * @param bool|null   $acceptsMarketing
     *
     * @return OrderUpdated
     * @throws DomainException
     */
    public function update(
        int $id,
        int $externalid = null,
        int $connectionid = null,
        string $email = null,
        bool $acceptsMarketing = null
    ): OrderUpdated
    {
        if (empty($id)) {
            throw new InvalidArgumentException('id cannot be empty');
        }

        $ecommOrder                     = [];
        $ecommOrder['externalid']       = $externalid;
        $ecommOrder['connectionid']     = $connectionid;
        $ecommOrder['email']            = $email;
        $ecommOrder['acceptsMarketing'] = (int)$acceptsMarketing;

        $ecommOrder = array_filter($ecommOrder);
        $params     = [];
        if (count($ecommOrder) > 0) {
            $params['ecomOrder'] = $ecommOrder;
        }

        $response = $this->httpPut(sprintf(self::ROUTE . '/%d', $id), $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;

                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, OrderUpdated::class);
    }

    /**
     * @param int $id
     *
     * @return OrderDeleted|ResponseInterface
     *
     * @throws Exception
     */
    public function delete(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpDelete(sprintf(self::ROUTE . '/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, OrderDeleted::class);
    }
}
