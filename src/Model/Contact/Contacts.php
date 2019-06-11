<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Contact;

use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;
use Pixelperfect\ActiveCampaign\Model\Tweet\Tweet;

/**
 * Class Contacts
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
final class Contacts implements CreatableFromArray
{

    /**
     * @var Contact[]
     */
    private $contacts;

    /**
     * Contacts constructor.
     *
     * @param Contact[] $contacts
     */
    public function __construct(array $contacts)
    {
        foreach ($contacts as $contact) {
            if (!$contact instanceof Contact) {
                throw new InvalidArgumentException('All contacts must be an instance of ' . Contact::class);
            }
        }

        $this->contacts = $contacts;
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
        $contacts = [];
        foreach ($data['contacts'] as $contact) {
            $contacts[] = Contact::createFromArray($contact);
        }

        return new self ($contacts);
    }
}
