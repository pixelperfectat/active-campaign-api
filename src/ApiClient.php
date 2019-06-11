<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Pixelperfect\ActiveCampaign;

use Pixelperfect\ActiveCampaign\Api\DeepData\Connection;
use Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce\Customer;
use Pixelperfect\ActiveCampaign\Api\DeepData\Ecommerce\Order;
use Pixelperfect\ActiveCampaign\Hydrator\ModelHydrator;
use Pixelperfect\ActiveCampaign\Hydrator\Hydrator;
use Http\Client\HttpClient;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ApiClient
{

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     *
     * @param HttpClient          $httpClient
     * @param Hydrator|null       $hydrator
     * @param RequestBuilder|null $requestBuilder
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    )
    {
        $this->httpClient     = $httpClient;
        $this->hydrator       = $hydrator ?: new ModelHydrator();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
    }

    /**
     * @param HttpClientConfigurator $httpClientConfigurator
     * @param Hydrator|null          $hydrator
     * @param RequestBuilder|null    $requestBuilder
     *
     * @return ApiClient
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ): self
    {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestBuilder);
    }

    /**
     * @param string $apiKey
     *
     * @return ApiClient
     */
    public static function create(string $endpoint, string $apiKey): ApiClient
    {
        $httpClientConfigurator = (new HttpClientConfigurator())
            ->setEndpoint($endpoint)
            ->setApiKey($apiKey);

        return self::configure($httpClientConfigurator);
    }

    public function contacts()
    {
        return new Api\Contact($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    public function tags()
    {
        return new Api\Tag($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Connection
     */
    public function deepDataConnection(): Connection
    {
        return new Connection($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Customer
     */
    public function deepDataEcommerceCustomer(): Customer
    {
        return new Customer($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Order
     */
    public function deepDataEcommerceOrder()
    {
        return new Order($this->httpClient, $this->hydrator, $this->requestBuilder);
    }
}
