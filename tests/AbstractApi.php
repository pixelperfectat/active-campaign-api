<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\tests;

use PHPUnit\Framework\TestCase;
use Pixelperfect\ActiveCampaign\ApiClient;

/**
 * Class AbstractApi
 *
 * @package Pixelperfect\ActiveCampaign\tests
 */
class AbstractApi extends TestCase
{

    /**
     * @return ApiClient
     */
    protected function getApiClient(): ApiClient
    {
        $apiClient = ApiClient::create(
            'https://1559194652.api-us1.com',
            'dc79d8127bd0edb024f3cc4c121990857683bbcb30e70b622d8c66c28abb57db06e0f96c'
        );
        return $apiClient;
    }
}
