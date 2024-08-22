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

    public function tearDown(): void
    {
        parent::tearDown();

        restore_error_handler();
        restore_exception_handler();
    }
}
