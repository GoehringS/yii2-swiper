<?php

namespace ItSolutionsSG\yii2\swiper\assets;

use yii\web\AssetBundle;

/**
 * Class SwiperMinAsset.
 */
class SwiperMinAsset extends AssetBundle
{
    public $sourcePath = '@bower/swiper/src';

    public $js = [
        'js/swiper.min.js',
    ];

    public $css = [
        'css/swiper.css',
    ];
}
