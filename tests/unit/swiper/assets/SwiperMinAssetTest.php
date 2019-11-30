<?php

namespace renschs\yii2\swiper\tests\unit\swiper\assets;


use renschs\yii2\swiper\assets\SwiperMinAsset;
use renschs\yii2\swiper\tests\unit\BaseTestCase;

class SwiperMinAssetTest extends BaseTestCase
{

    public function testMain()
    {
        $this->assertInstanceOf(SwiperMinAsset::class, SwiperMinAsset::register(\Yii::$app->getView()));
    }
}
