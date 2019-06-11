<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Api;

/**
 * Class ServiceInterface
 *
 * @package Pixelperfect\ActiveCampaign\Api
 */
interface ServiceInterface
{

    /**
     *
     * @param array $data
     */
    public function create(array $data);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function get(int $id);

    /**
     *
     * @return mixed
     */
    public function list();

    /**
     *
     * @param int $id
     *
     * @return mixed
     */
    public function update(int $id);

    /**
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id);
}
