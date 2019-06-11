<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Contact;

use DateTimeImmutable;
use Exception;
use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class ContactTagged
 *
 * @package Pixelperfect\ActiveCampaign\Model\Contact
 */
class ContactTagged extends AbstractModel implements CreatableFromArray
{

    /**
     * @var ?DateTimeImmutable
     */
    private $cdate;

    /**
     * @var int
     */
    private $contactId;

    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $links;

    /**
     * @var int
     */
    private $tagId;

    /**
     * ContactTagged constructor.
     *
     * @param $data
     *
     * @throws Exception
     */
    public function __construct($data)
    {
        if (array_key_exists('contactTag', $data)) {
            extract($data['contactTag']);
        } else {
            extract($data);
        }
        $this->setCdate(static::createDateObject($cdate ?? null))
            ->setContactId((int)$contact)
            ->setId((int)$id)
            ->setLinks($links)
            ->setTagId((int)$tag);
    }

    /**
     * @return mixed
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * @param ?DateTimeImmutable $cdate
     *
     * @return ContactTagged
     */
    public function setCdate(?DateTimeImmutable $cdate)
    {
        $this->cdate = $cdate;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param int $contactId
     *
     * @return ContactTagged
     */
    public function setContactId(int $contactId): ContactTagged
    {
        $this->contactId = $contactId;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ContactTagged
     */
    public function setId(int $id): ContactTagged
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return ContactTagged
     */
    public function setLinks(array $links): ContactTagged
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return int
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @param int $tagId
     *
     * @return ContactTagged
     */
    public function setTagId(int $tagId): ContactTagged
    {
        $this->tagId = $tagId;
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
