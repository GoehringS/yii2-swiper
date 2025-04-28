<?php

namespace ItSolutionsSG\yii2\swiper\tests\unit\swiper\assets;

use ItSolutionsSG\yii2\swiper\assets\SwiperJqueryAsset;
use ItSolutionsSG\yii2\swiper\tests\unit\BaseTestCase;

class SwiperJqueryAssetTest extends BaseTestCase
{
    public function testMain()
    {
        $this->assertInstanceOf(SwiperJqueryAsset::class, SwiperJqueryAsset::register(\Yii::$app->getView()));
    }
}
