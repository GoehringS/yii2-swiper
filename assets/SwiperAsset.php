<?php

namespace ItSolutionsSG\yii2\swiper\assets;

use yii\web\AssetBundle;

/**
 * Class SwiperAsset.
 */
class SwiperAsset extends AssetBundle
{
    public $sourcePath = '@bower/swiper/src';

    public $js = [
        'js/swiper.js',
    ];

    public $css = [
        'css/swiper.css',
    ];
}
