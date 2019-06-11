<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Api\DeepData;

use Exception;
use Pixelperfect\ActiveCampaign\Api\HttpApi;
use Pixelperfect\ActiveCampaign\Api\ServiceInterface;
use Pixelperfect\ActiveCampaign\Exception\Domain\ValidationException;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\DeepData\ConnectionCreated;
use Pixelperfect\ActiveCampaign\Model\DeepData\ConnectionDeleted;
use Pixelperfect\ActiveCampaign\Model\DeepData\Connections;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetDeleted;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DeepData
 *
 * @package Pixelperfect\ActiveCampaign\Api
 */
final class Connection extends HttpApi implements ServiceInterface
{

    /**
     * Create a deep data connection
     *
     * @param array $data
     *
     * @return ConnectionCreated
     * @throws Exception
     */
    public function create(array $data): ConnectionCreated
    {
        $requiredParams = ['service', 'externalid', 'name', 'logoUrl', 'linkUrl'];

        $this->validateRequiredParams($data, $requiredParams);

        $connection = [
            'service'    => $data['service'],
            'externalid' => $data['externalid'],
            'name'       => $data['name'],
            'logoUrl'    => $data['logoUrl'],
            'linkUrl'    => $data['linkUrl']
        ];

        $params['connection'] = $connection;

        $response = $this->httpPost('/api/3/connections', $params);

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

        return $this->hydrator->hydrate($response, ConnectionCreated::class);
    }

    /**
     * @param int $id
     *
     * @return mixed|void
     * @throws Exception
     */
    public function get(int $id)
    {
        throw new Exception('Not yet implemented');
    }

    /**
     * @param string|null $email
     * @param string|null $externalid
     *
     * @return Connections
     */
    public function list(string $email = null, string $externalid = null): Connections
    {
        $filters               = [];
        $filters['service']    = $email;
        $filters['externalid'] = $externalid;

        $filters = array_filter($filters);
        $params  = [];
        if (count($filters) > 0) {
            $params['filters'] = $filters;
        }

        $response = $this->httpGet('/api/3/connections', $params);

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

        return $this->hydrator->hydrate($response, Connections::class);
    }

    /**
     * @param int $id
     *
     * @return mixed|void
     * @throws Exception
     */
    public function update(int $id)
    {
        throw new Exception('Not yet implemented');
    }

    /**
     * @param int $id
     *
     * @return TweetDeleted|ResponseInterface
     *
     * @throws \Pixelperfect\ActiveCampaign\Exception
     */
    public function delete(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpDelete(sprintf('/api/3/connections/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ConnectionDeleted::class);
    }
}
