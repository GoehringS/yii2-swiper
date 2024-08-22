<?php
namespace renschs\yii2\swiper\assets;


use yii\web\AssetBundle;

/**
 * Class SwiperMinAsset
 *
 * @package renschs\yii2\swiper\assets
 */
class SwiperMinAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/swiper/src';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/swiper.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/swiper.css',
    ];

}