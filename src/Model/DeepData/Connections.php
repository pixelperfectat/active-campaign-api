<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Model\DeepData;

use Pixelperfect\ActiveCampaign\Exception\InvalidArgumentException;
use Pixelperfect\ActiveCampaign\Model\AbstractModelCollection;
use Pixelperfect\ActiveCampaign\Model\CreatableFromArray;
use Pixelperfect\ActiveCampaign\Model\Tweet\Tweet;
use stdClass;

/**
 * Class Connections
 *
 * @package Pixelperfect\ActiveCampaign\Model\DeepData
 */
final class Connections extends AbstractModelCollection
{

    const DATA_OBJECT_KEY = 'connections';

    /**
     * @return mixed
     */
    public static function getModelClassname()
    {
        return Connection::class;
    }
}
