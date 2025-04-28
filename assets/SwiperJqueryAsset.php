<?php

namespace ItSolutionsSG\yii2\swiper\assets;

use yii\web\AssetBundle;

/**
 * Class SwiperJqueryAsset.
 */
class SwiperJqueryAsset extends AssetBundle
{
    public $sourcePath = '@bower/swiper/src';

    public $js = [
        'js/swiper.jquery.js',
    ];

    public $css = [
        'css/swiper.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
