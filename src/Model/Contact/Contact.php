<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\Contact;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Pixelperfect\ActiveCampaign\Model\AbstractModel;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class Contact
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
final class Contact extends AbstractModel implements CreatableFromArray
{

    /**
     * @var string
     */
    private $account;

    /**
     * @var DateTimeInterface | null
     */
    private $adate;

    /**
     * @var bool
     */
    private $anonymized;

    /**
     * @var DateTimeInterface | null
     */
    private $bounced_date;

    /**
     * @var bool
     */
    private $bounced_hard;

    /**
     * @var bool
     */
    private $bounced_soft;

    /**
     * @var DateTimeInterface | null
     */
    private $cdate;

    /**
     * @var DateTimeInterface | null
     */
    private $created_utc_timestamp;

    /**
     * @var bool
     */
    private $customerAccount;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var DateTimeInterface | null
     */
    private $deleted_at;

    /**
     * @var DateTimeInterface | null
     */
    private $edate;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $email_domain;

    /**
     * @var string
     */
    private $email_local;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var bool
     */
    private $gravatar;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $ip;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var array
     */
    private $links;

    /**
     * @var string
     */
    private $organization;

    /**
     * @var int
     */
    private $orgid;

    /**
     * @var string
     */
    private $orgname;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var DateTimeInterface | null
     */
    private $rating_tstamp;

    /**
     * @var array
     */
    private $scoreValues;

    /**
     * @var string
     */
    private $segmentio_id;

    /**
     * @var string
     */
    private $sentcnt;

    /**
     * @var DateTimeInterface | null
     */
    private $socialdata_lastcheck;

    /**
     * @var string
     */
    private $ua;

    /**
     * @var DateTimeInterface | null
     */
    private $udate;

    /**
     * @var DateTimeInterface | null
     */
    private $updated_utc_timestamp;

    /**
     * Contact constructor.
     *
     * @param $data
     *
     * @throws Exception
     *
     */
    public function __construct($data)
    {
        if (array_key_exists('contact', $data)) {
            extract($data['contact']);
        } else {
            extract($data);
        }

        $this->setAccount($account)
            ->setAdate(static::createDateObject($adate ?? null))
            ->setAnonymized((bool)$anonymized ?? null)
            ->setBouncedDate(static::createDateObject($bounced_date))
            ->setBouncedHard((bool)$bounced_hard ?? null)
            ->setBouncedSoft((bool)$bounced_soft ?? null)
            ->setCdate(static::createDateObject($cdate))
            ->setCreatedUtcTimestamp(static::createDateObject($created_utc_timestamp))
            ->setCustomerAccount((bool)$customerAccount ?? null)
            ->setDeleted((bool)$deleted ?? false)
            ->setDeletedAt(static::createDateObject($deleted_at))
            ->setEdate(static::createDateObject($edate ?? null))
            ->setEmail($email)
            ->setEmailDomain($email_domain ?? null)
            ->setEmailLocal($email_local ?? null)
            ->setFirstName($firstName)
            ->setGravatar((bool)$gravatar ?? false)
            ->setHash($hash ?? null)
            ->setId((int)$id)
            ->setIp($ip ?? null)
            ->setLastName($lastName)
            ->setLinks($links)
            ->setOrganization($organization ?? null)
            ->setOrgid((int)$orgid ?? null)
            ->setOrgname($orgname ?? null)
            ->setPhone($phone ?? null)
            ->setRatingTstamp(self::createDateObject($rating_tstamp))
            ->setScoreValues($scoreValues ?? [])
            ->setSegmentioId($segmentio_id ?? null)
            ->setSentcnt($sentcnt ?? null)
            ->setSocialdataLastcheck(static::createDateObject($socialdata_lastcheck))
            ->setUa($ua ?? null)
            ->setUdate(static::createDateObject($udate ?? null))
            ->setUpdatedUtcTimestamp(static::createDateObject($updated_utc_timestamp));
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param string $account
     *
     * @return Contact
     */
    public function setAccount(?string $account): Contact
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAdate(): ?DateTimeInterface
    {
        return $this->adate;
    }

    /**
     * @param DateTimeInterface|null $adate
     *
     * @return Contact
     */
    public function setAdate(?DateTimeInterface $adate): Contact
    {
        $this->adate = $adate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAnonymized(): bool
    {
        return $this->anonymized;
    }

    /**
     * @param bool|null $anonymized
     *
     * @return Contact
     */
    public function setAnonymized(?bool $anonymized): Contact
    {
        $this->anonymized = $anonymized;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBouncedDate(): ?DateTimeInterface
    {
        return $this->bounced_date;
    }

    /**
     * @param DateTimeInterface|null $bounced_date
     *
     * @return Contact
     */
    public function setBouncedDate(?DateTimeInterface $bounced_date): Contact
    {
        $this->bounced_date = $bounced_date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBouncedHard(): bool
    {
        return $this->bounced_hard;
    }

    public function setBouncedHard(?bool $bounced_hard): Contact
    {
        $this->bounced_hard = $bounced_hard;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBouncedSoft(): bool
    {
        return $this->bounced_soft;
    }

    public function setBouncedSoft(?bool $bounced_soft): Contact
    {
        $this->bounced_soft = $bounced_soft;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCdate(): ?DateTimeInterface
    {
        return $this->cdate;
    }

    /**
     * @param DateTimeInterface|null $cdate
     *
     * @return Contact
     */
    public function setCdate(?DateTimeInterface $cdate): Contact
    {
        $this->cdate = $cdate;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedUtcTimestamp(): ?DateTimeInterface
    {
        return $this->created_utc_timestamp;
    }

    /**
     * @param DateTimeInterface|null $created_utc_timestamp
     *
     * @return Contact
     */
    public function setCreatedUtcTimestamp(?DateTimeInterface $created_utc_timestamp): Contact
    {
        $this->created_utc_timestamp = $created_utc_timestamp;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomerAccount(): bool
    {
        return $this->customerAccount;
    }

    public function setCustomerAccount(?bool $customerAccount): Contact
    {
        $this->customerAccount = $customerAccount;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): Contact
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deleted_at;
    }

    /**
     * @param DateTimeInterface|null $deleted_at
     *
     * @return Contact
     */
    public function setDeletedAt(?DateTimeInterface $deleted_at): Contact
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEdate(): ?DateTimeInterface
    {
        return $this->edate;
    }

    /**
     * @param DateTimeInterface|null $edate
     *
     * @return Contact
     */
    public function setEdate(?DateTimeInterface $edate): Contact
    {
        $this->edate = $edate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailDomain(): string
    {
        return $this->email_domain;
    }

    public function setEmailDomain(?string $email_domain): Contact
    {
        $this->email_domain = $email_domain;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailLocal(): string
    {
        return $this->email_local;
    }

    public function setEmailLocal(?string $email_local): Contact
    {
        $this->email_local = $email_local;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Contact
     */
    public function setFirstName(string $firstName): Contact
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGravatar(): bool
    {
        return $this->gravatar;
    }

    public function setGravatar(bool $gravatar): Contact
    {
        $this->gravatar = $gravatar;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): Contact
    {
        $this->hash = $hash;
        return $this;
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
     * @return Contact
     */
    public function setId(int $id): Contact
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIp(): int
    {
        return $this->ip;
    }

    public function setIp(?string $ip): Contact
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Contact
     */
    public function setLastName(string $lastName): Contact
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return Contact
     */
    public function setLinks(array $links): Contact
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganization(): string
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     *
     * @return Contact
     */
    public function setOrganization(?string $organization): Contact
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrgid(): int
    {
        return $this->orgid;
    }

    public function setOrgid(?int $orgid): Contact
    {
        $this->orgid = $orgid;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrgname(): string
    {
        return $this->orgname;
    }

    public function setOrgname(?string $orgname): Contact
    {
        $this->orgname = $orgname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getRatingTstamp(): ?DateTimeInterface
    {
        return $this->rating_tstamp;
    }

    /**
     * @param DateTimeInterface|null $rating_tstamp
     *
     * @return Contact
     */
    public function setRatingTstamp(?DateTimeInterface $rating_tstamp): Contact
    {
        $this->rating_tstamp = $rating_tstamp;
        return $this;
    }

    /**
     * @return array
     */
    public function getScoreValues(): array
    {
        return $this->scoreValues;
    }

    /**
     * @param array $scoreValues
     *
     * @return Contact
     */
    public function setScoreValues(array $scoreValues): Contact
    {
        $this->scoreValues = $scoreValues;
        return $this;
    }

    /**
     * @return string
     */
    public function getSegmentioId(): string
    {
        return $this->segmentio_id;
    }

    public function setSegmentioId(?string $segmentio_id): Contact
    {
        $this->segmentio_id = $segmentio_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSentcnt(): string
    {
        return $this->sentcnt;
    }

    public function setSentcnt(?string $sentcnt): Contact
    {
        $this->sentcnt = $sentcnt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSocialdataLastcheck(): ?DateTimeInterface
    {
        return $this->socialdata_lastcheck;
    }

    /**
     * @param DateTimeInterface|null $socialdata_lastcheck
     *
     * @return Contact
     */
    public function setSocialdataLastcheck(?DateTimeInterface $socialdata_lastcheck): Contact
    {
        $this->socialdata_lastcheck = $socialdata_lastcheck;
        return $this;
    }

    /**
     * @return string
     */
    public function getUa(): string
    {
        return $this->ua;
    }

    /**
     * @param string $ua
     *
     * @return Contact
     */
    public function setUa(?string $ua): Contact
    {
        $this->ua = $ua;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUdate(): ?DateTimeInterface
    {
        return $this->udate;
    }

    /**
     * @param DateTimeInterface|null $udate
     *
     * @return Contact
     */
    public function setUdate(?DateTimeInterface $udate): Contact
    {
        $this->udate = $udate;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedUtcTimestamp(): ?DateTimeInterface
    {
        return $this->updated_utc_timestamp;
    }

    /**
     * @param DateTimeInterface|null $updated_utc_timestamp
     *
     * @return Contact
     */
    public function setUpdatedUtcTimestamp(?DateTimeInterface $updated_utc_timestamp): Contact
    {
        $this->updated_utc_timestamp = $updated_utc_timestamp;
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

}
