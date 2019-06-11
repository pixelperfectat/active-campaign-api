<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Tag;

use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class Tag
 *
 * @package Pixelperfect\ActiveCampaign\Model\Tag
 */
final class Tag extends AbstractModel implements CreatableFromArray
{

    private $name;

    private $type;

    private $description;

    private $cdate;

    private $links;

    private $id;

    public function __construct(array $data)
    {
        if (array_key_exists('tag', $data)) {
            extract($data['tag']);
        } else {
            extract($data);
        }

        $this->setLinks($links)
            ->setId((int)$id)
            ->setCdate(static::createDateObject($cdate) ?? null)
            ->setLinks($links)
            ->setDescription($description)
            ->setName($tag)
            ->setType($tagType);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return Tag
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Tag
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * @param mixed $cdate
     *
     * @return Tag
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param mixed $links
     *
     * @return Tag
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Tag
     */
    public function setId($id)
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
        return new self($data);
    }
}
