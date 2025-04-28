<?php

namespace ItSolutionsSG\yii2\swiper\tests\unit\swiper\assets;

use ItSolutionsSG\yii2\swiper\assets\SwiperAsset;
use ItSolutionsSG\yii2\swiper\tests\unit\BaseTestCase;

class SwiperAssetTest extends BaseTestCase
{
    public function testMain()
    {
        $this->assertInstanceOf(SwiperAsset::class, SwiperAsset::register(\Yii::$app->getView()));
    }
}
