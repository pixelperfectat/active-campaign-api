<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Tag;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class TagCreated
 *
 * @package Pixelperfect\ActiveCampaign\Model\Tag
 */
class TagCreated implements CreatableFromArray
{

    /**
     * @var Tag
     */
    private $tag;

    /**
     * @param string $contact
     */
    private function __construct(Contact $contact)
    {
        $this->tag = $contact;
    }

    /**
     * @param array $data
     *
     * @return TagCreated
     */
    public static function createFromArray(array $data): TagCreated
    {
        $contact = '';

        if (isset($data['tag'])) {
            $contact = Tag::createFromArray($data['tag']);
        }

        return new self($contact);
    }

    /**
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }
}
