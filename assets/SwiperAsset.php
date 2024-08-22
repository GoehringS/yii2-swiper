<?php
namespace renschs\yii2\swiper\assets;

use yii\web\AssetBundle;

/**
 * Class SwiperAsset
 *
 * @package renschs\yii2\swiper\assets
 */
class SwiperAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/swiper/src';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/swiper.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/swiper.css',
    ];

}