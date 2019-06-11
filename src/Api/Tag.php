<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Api;

use Pixelperfect\ActiveCampaign\Exception;
use Pixelperfect\ActiveCampaign\Exception\DomainException;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\Tag\Tag as TagModel;
use Pixelperfect\ActiveCampaign\Model\Tag\TagCreated;
use Pixelperfect\ActiveCampaign\Model\Tweet\Tweet as TweetModel;
use Psr\Http\Message\ResponseInterface as ResponseInterfaceAlias;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Tag
 *
 * @package Pixelperfect\ActiveCampaign\Api
 */
class Tag extends HttpApi
{

    const TAG_TYPE_CONTACT  = 'contact';
    const TAG_TYPE_TEMPLATE = 'template';

    /**
     * @param string $name
     * @param string $type
     * @param string $description
     *
     * @return mixed|ResponseInterfaceAlias
     * @throws DomainException
     */
    public function create(string $name, string $type = self::TAG_TYPE_CONTACT, string $description = null)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Tag name is required');
        }

        $tag = [
            'tag'         => $name,
            'tagType'     => $type,
            'description' => $description,
        ];

        $tag = array_filter($tag);

        $params['tag'] = $tag;

        $response = $this->httpPost('/api/3/tags', $params);

        if (!$this->hydrator) {
            return $response;
        }

        $allowedResponseCodes = [200, 201];

        // Use any valid status code here
        if (!in_array($response->getStatusCode(), $allowedResponseCodes)) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new DomainExceptions\ValidationException();
                    break;

                default:
                    $this->handleErrors($response);
                    break;
            }
        }

        return $this->hydrator->hydrate($response, TagCreated::class);
    }

    /**
     * @param int $id
     *
     * @return TweetModel|ResponseInterface
     *
     * @throws Exception
     */
    public function get(int $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Id cannot be empty');
        }

        $response = $this->httpGet(sprintf('/api/3/tags/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TagModel::class);
    }
}
