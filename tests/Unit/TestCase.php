<?php
declare(strict_types=1);
/**
 * Copyright © André Flitsch. All rights reserved.
 * See license.md for license details.
 */

namespace Pixelperfect\ActiveCampaign\Tests\Unit;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * Class TestCase
 *
 * @package Pixelperfect\ActiveCampaign\Tests\Unit
 */
class TestCase extends PhpUnitTestCase
{

    protected static function getMethod(object $obj, string $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
