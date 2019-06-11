<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Contact;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class ContactCreated
 *
 * @package Pixelperfect\ActiveCampaign\Model\Contact
 */
class ContactCreated implements CreatableFromArray
{

    /**
     * @var Contact
     */
    private $contact;

    /**
     * @param string $contact
     */
    private function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @param array $data
     *
     * @return TweetCreated
     */
    public static function createFromArray(array $data): ContactCreated
    {
        $contact = '';

        if (isset($data['contact'])) {
            $contact = Contact::createFromArray($data['contact']);
        }

        return new self($contact);
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }
}
