<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Validator\DeepData\Ecommerce;

use DateTimeInterface;
use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Validator\Validator;

/**
 * Class Order
 *
 * @package Pixelperfect\ActiveCampaign\Validator\DeepData\Ecommerce
 */
class Order implements Validator
{

    /**
     * @param array $data
     *
     * @return mixed|void
     * @throws InvalidArgumentException
     */
    public function validateParams(array $data)
    {
        $requiredParams        = [
            'externalid', 'email', 'totalPrice', 'currency', 'connectionid', 'customerid', 'orderDate'
        ];
        $missingRequiredParams = array_diff_key($requiredParams, array_keys($data));
        if (count($missingRequiredParams) > 0) {
            $paramValidationMessage = [];
            foreach ($missingRequiredParams as $missingRequiredParam) {
                $paramValidationMessage[] = "Parameter $missingRequiredParam is missing" . PHP_EOL;
            }
            throw new InvalidArgumentException(implode('', $paramValidationMessage));
        }

        $invalidParamType = [];
        foreach ($requiredParams as $requiredParam) {
            if (!$this->{'validateParameter' . ucfirst($requiredParam)}($data[$requiredParam])) {
                $invalidParamType[] = sprintf('parameter %s is the wrong type', $requiredParam);
            }
        }
        if (count($invalidParamType) > 0) {
            throw new InvalidArgumentException(implode('', $invalidParamType));
        }
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterExternalid($value): bool
    {
        return !empty($value);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterEmail($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterTotalPrice($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) ? true : false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterCurrency($value): bool
    {
        if (strlen($value) == 3) {
            return true;
        }
        return false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterConnectionid($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) ? true : false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterCustomerid($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) ? true : false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function validateParameterOrderDate($value): bool
    {
        return is_string($value);
    }
}
