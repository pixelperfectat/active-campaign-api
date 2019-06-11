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
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\Customer as CustomerModel;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\CustomerCreated;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\CustomerDeleted;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\Customers;
use Pixelperfect\ActiveCampaign\Model\DeepData\Ecommerce\Customer\CustomerUpdated;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetUpdated;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Customer
 *
 * @package Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce
 */
final class Customer extends HttpApi implements ServiceInterface
{

    const ROUTE = '/api/3/ecomCustomers';

    /**
     * @param array $data
     *
     * @return CustomerCreated
     * @throws DomainException
     */
    public function create(array $data): CustomerCreated
    {
        $requiredParams = ['connectionid', 'externalid', 'email', 'acceptsMarketing'];
        $this->validateRequiredParams($data, $requiredParams);

        $ecommCustomer = [
            'connectionid'     => $data['connectionid'],
            'externalid'       => $data['externalid'],
            'email'            => $data['email'],
            'acceptsMarketing' => $data['acceptsMarketing']
        ];

        $params['ecomCustomer'] = $ecommCustomer;

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

        return $this->hydrator->hydrate($response, CustomerCreated::class);
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

        return $this->hydrator->hydrate($response, CustomerModel::class);
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

        return $this->hydrator->hydrate($response, Customers::class);
    }

    /**
     * @param int         $id
     * @param int|null    $externalid
     * @param int|null    $connectionid
     * @param string|null $email
     * @param bool|null   $acceptsMarketing
     *
     * @return CustomerUpdated
     * @throws DomainException
     */
    public function update(
        int $id,
        int $externalid = null,
        int $connectionid = null,
        string $email = null,
        bool $acceptsMarketing = null
    ): CustomerUpdated
    {
        if (empty($id)) {
            throw new InvalidArgumentException('id cannot be empty');
        }

        $ecommCustomer                     = [];
        $ecommCustomer['externalid']       = $externalid;
        $ecommCustomer['connectionid']     = $connectionid;
        $ecommCustomer['email']            = $email;
        $ecommCustomer['acceptsMarketing'] = (int)$acceptsMarketing;

        $ecommCustomer = array_filter($ecommCustomer);
        $params  = [];
        if (count($ecommCustomer) > 0) {
            $params['ecomCustomer'] = $ecommCustomer;
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

        return $this->hydrator->hydrate($response, CustomerUpdated::class);
    }

    /**
     * @param int $id
     *
     * @return CustomerDeleted|ResponseInterface
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

        return $this->hydrator->hydrate($response, CustomerDeleted::class);
    }
}
