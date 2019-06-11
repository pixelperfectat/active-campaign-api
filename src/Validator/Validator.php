<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Validator;

interface Validator
{

    /**
     * Validate the input params
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validateParams(array $data);
}
