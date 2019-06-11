<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model;

/**
 * Class AbstractModelDeleted
 *
 * @package Pixelperfect\ActiveCampaign\Model
 */
abstract class AbstractModelDeleted implements CreatableFromArray
{

    /**
     * @var string
     */
    protected $message;

    /**
     * @param string $message
     */
    protected function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param array $data
     *
     * @return AbstractModelDeleted
     */
    public static function createFromArray(array $data): self
    {
        $message = '';

        if (isset($data['message'])) {
            $message = $data['message'];
        }

        return new static($message);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return strlen($this->getMessage()) > 0 ? false : true;
    }
}
