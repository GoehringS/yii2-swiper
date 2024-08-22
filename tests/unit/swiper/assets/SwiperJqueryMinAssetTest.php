<?php
namespace renschs\yii2\swiper\tests\unit\swiper\assets;


use renschs\yii2\swiper\assets\SwiperJqueryMinAsset;
use renschs\yii2\swiper\tests\unit\BaseTestCase;

class SwiperJqueryMinAssetTest extends BaseTestCase
{

    public function testMain()
    {
       $this->assertInstanceOf(SwiperJqueryMinAsset::class, SwiperJqueryMinAsset::register( \Yii::$app->getView() ));
    }

}
