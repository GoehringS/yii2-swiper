<?php

namespace ItSolutionsSG\yii2\swiper\tests\unit;

use PHPUnit\Framework\TestCase;
use yii\console\Application;

class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        new Application(require __DIR__.'/config.php');
    }

    public function tearDown(): void
    {
        parent::tearDown();

        restore_error_handler();
        restore_exception_handler();
    }
}
