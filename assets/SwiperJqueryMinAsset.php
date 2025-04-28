<?php

namespace ItSolutionsSG\yii2\swiper\assets;

use yii\web\AssetBundle;

/**
 * Class SwiperJqueryMinAsset.
 */
class SwiperJqueryMinAsset extends AssetBundle
{
    public $sourcePath = '@bower/swiper/src';

    public $js = [
        'js/swiper.jquery.min.js',
    ];

    public $css = [
        'css/swiper.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
