<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData;

use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class Connection
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData
 */
class Connection extends AbstractModel implements CreatableFromArray
{

    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $externalid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $logoUrl;

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var int
     */
    private $id;

    /**
     * Connection constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (array_key_exists('connection', $data)) {
            extract($data['connection']);
        } else {
            extract($data);
        }

        $this->setService($service)
            ->setExternalid($externalid)
            ->setName($name)
            ->setLogoUrl($logoUrl)
            ->setLinkUrl($linkUrl)
            ->setId((int)$id);
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
     * @return Connection
     */
    public function setId(int $id): Connection
    {
        $this->id = $id;
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
        return new self ($data);
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return Connection
     */
    public function setService(string $service): Connection
    {
        $this->service = $service;
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
     * @return Connection
     */
    public function setExternalid(string $externalid): Connection
    {
        $this->externalid = $externalid;
        return $this;
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
     * @return Connection
     */
    public function setName(string $name): Connection
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogoUrl(): string
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     *
     * @return Connection
     */
    public function setLogoUrl(string $logoUrl): Connection
    {
        $this->logoUrl = $logoUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkUrl(): string
    {
        return $this->linkUrl;
    }

    /**
     * @param string $linkUrl
     *
     * @return Connection
     */
    public function setLinkUrl(string $linkUrl): Connection
    {
        $this->linkUrl = $linkUrl;
        return $this;
    }
}
