<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests;

use Exception;
use Pixelperfect\ActiveCampaign\ApiClient;
use Pixelperfect\ActiveCampaign\Model\Contact\Contact;
use Pixelperfect\ActiveCampaign\Model\Contact\ContactCreated;
use Pixelperfect\ActiveCampaign\Model\Contact\Contacts;
use Pixelperfect\ActiveCampaign\Model\Contact\ContactTagged;
use Pixelperfect\ActiveCampaign\Model\Tag\Tag;

class ApiClientTest extends AbstractApi
{

    public function testCreate()
    {
        try {
            $apiClient = $this->getApiClient();
            $this->assertInstanceOf(ApiClient::class, $apiClient);
        } catch (Exception $e) {
            $this->fail('didnt work');
        }
    }

    public function testContactListAll()
    {
        $apiClient = $this->getApiClient();
        $contacts  = $apiClient->contacts()->listAll();
        $this->assertInstanceOf(Contacts::class, $contacts);
    }

    public function testGetContactById()
    {
        $contact = $this->getContactById(6);
        $this->assertEquals('André', $contact->getFirstName());
        $this->assertEquals('andre1@pixelperfect.at', $contact->getEmail());
    }

    public function testCreateContact()
    {
        // $this->fail('didnt work');
        $apiClient = $this->getApiClient();
        /** @var ContactCreated $contactCreated */
        $contactCreated = $apiClient->contacts()->create('test@somedomain.com');
        $this->assertInstanceOf(ContactCreated::class, $contactCreated);
        $this->assertInstanceOf(Contact::class, $contactCreated->getContact());
    }

    public function testGetTag()
    {
        $tag = $this->getTagById(1);

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertEquals('My Test Tag', $tag->getName());
    }

    public function testCreateTag()
    {
        /** @var ApiClient $apiClient */
        $apiClient = $this->getApiClient();
        $apiClient->tags()->create('My Test Tag');
    }

    public function testTagContact()
    {
        /** @var Contact $contact */
        $contact   = $this->getContactById(6);
        $contactId = $contact->getId();

        $this->assertEquals(6, $contactId);

        $tag   = $this->getTagById(1);
        $tagId = $tag->getId();

        /** @var ApiClient $apiClient */
        $apiClient = $this->getApiClient();

        /** @var ContactTagged $contactTagged */
        $contactTagged = $apiClient->contacts()->tag($contactId, $tagId);

        $taggedContact = $this->getContactById($contactTagged->getContactId());
    }

    /**
     * @param int $id
     *
     * @return Contact
     * @throws \Pixelperfect\ActiveCampaign\Exception
     */
    private function getContactById(int $id): Contact
    {
        $apiClient = $this->getApiClient();
        /** @var Contact $contact */
        $contact = $apiClient->contacts()->get($id);
        $this->assertInstanceOf(Contact::class, $contact);
        return $contact;
    }

    /**
     * @param int $id
     *
     * @return Tag
     * @throws \Pixelperfect\ActiveCampaign\Exception
     */
    private function getTagById(int $id): Tag
    {
        /** @var ApiClient $apiClient */
        $apiClient = $this->getApiClient();

        /** @var Tag $tag */
        $tag = $apiClient->tags()->get($id);
        return $tag;
    }
}
