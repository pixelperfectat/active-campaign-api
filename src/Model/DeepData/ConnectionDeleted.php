<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData;

use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;

/**
 * Class ConnectionDeleted
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData
 */
final class ConnectionDeleted implements CreatableFromArray
{

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $message
     */
    private function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param array $data
     *
     * @return ConnectionDeleted
     */
    public static function createFromArray(array $data): ConnectionDeleted
    {
        $message = '';

        if (isset($data['message'])) {
            $message = $data['message'];
        }

        return new self($message);
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
