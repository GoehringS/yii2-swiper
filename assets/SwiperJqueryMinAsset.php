<?php
namespace renschs\yii2\swiper\assets;


use yii\web\AssetBundle;

/**
 * Class SwiperJqueryMinAsset
 *
 * @package renschs\yii2\swiper\assets
 */
class SwiperJqueryMinAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/swiper/src';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/swiper.jquery.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/swiper.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}