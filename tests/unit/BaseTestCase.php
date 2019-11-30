<?php

namespace renschs\yii2\swiper\tests\unit;

use yii\console\Application;
use PHPUnit\Framework\TestCase;


class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        new Application(require(__DIR__ . '/config.php'));
    }
}
