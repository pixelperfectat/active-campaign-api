<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Pixelperfect\ActiveCampaign\Api;

use Pixelperfect\ActiveCampaign\Exception;
use Pixelperfect\ActiveCampaign\Exception\Domain as DomainExceptions;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\Contact\Contact as ContactModel;
use Pixelperfect\ActiveCampaign\Model\Contact\ContactCreated;
use Pixelperfect\ActiveCampaign\Model\Contact\Contacts;
use Pixelperfect\ActiveCampaign\Model\Contact\ContactTagged;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetCreated;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetDeleted;
use Pixelperfect\ActiveCampaign\Model\Tweet\Tweets;
use Pixelperfect\ActiveCampaign\Model\Tweet\Tweet as TweetModel;
use Pixelperfect\ActiveCampaign\Model\Tweet\TweetUpdated;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Contact extends HttpApi
{

    /**
     * @param array $params
     *
     * @return Tweets|ResponseInterface
     *
     * @throws Exception
     */
    public function listAll(array $params = [])
    {
        $response = $this->httpGet('/api/3/contacts', $params);

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Contacts::class);
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

        $response = $this->httpGet(sprintf('/api/3/contacts/%d', $id));

        if (!$this->hydrator) {
            return $response;
        }

        // Use any valid status code here
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, ContactModel::class);
    }

    /**
     * @param string      $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param int|null    $orgid
     * @param bool|null   $deleted
     *
     * @return mixed|ResponseInterface
     * @throws Exception\DomainException
     * @throws Exception\Domain\ValidationException
     */
    public function create(
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?int $orgid = null,
        ?bool $deleted = null
    )
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Email is required');
        }

        $contact = [
            'email'     => $email,
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'orgid'     => $orgid,
            'phone'     => $phone,
        ];

        $contact = array_filter($contact);

        $params['contact'] = $contact;

        $response = $this->httpPost('/api/3/contact/sync', $params);

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

        return $this->hydrator->hydrate($response, ContactCreated::class);
    }

    public function tag(int $contactID, int $tagId)
    {
        if (empty($contactID)) {
            throw new InvalidArgumentException('contactID cannot be empty');
        }

        if (empty($tagId)) {
            throw new InvalidArgumentException('tagId cannot be empty');
        }

        $contactTag = [
            'contact' => $contactID,
            'tag'     => $tagId
        ];

        $contactTag = array_filter($contactTag);

        $params['contactTag'] = $contactTag;

        $response = $this->httpPost('/api/3/contactTags', $params);

        if (!$this->hydrator) {
            return $response;
        }

        $allowedResponseCodes = [200, 201];

        // Use any valid status code here
        if (!in_array($response->getStatusCode(), $allowedResponseCodes)) {
            switch ($response->getStatusCode()) {
                case 404:
                    throw new DomainExceptions\NotFoundException('tag with Id ' . $tagId . ' was not found');
                    break;
                case 422:
                    throw new DomainExceptions\ValidationException($response->getBody());
                    break;
                default:
                    $this->handleErrors($response);
                    break;
            }
        }
        return $this->hydrator->hydrate($response, ContactTagged::class);
    }

}
