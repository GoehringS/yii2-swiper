<?php

/**
 * @var yii\web\View $this
 */

use ItSolutionsSG\yii2\swiper\Swiper;

echo Swiper::widget([
    'items' => [
        'Slide 1',
        'Slide 2',
        'Slide 3',
        'Slide 4',
        'Slide 5',
        'Slide 6',
        'Slide 7',
        'Slide 8',
        'Slide 9',
        'Slide 10',
    ],
    'behaviours' => [
        Swiper::BEHAVIOUR_PAGINATION,
        Swiper::BEHAVIOUR_NAVIGATION,
        Swiper::BEHAVIOUR_NEXT_BUTTON,
        Swiper::BEHAVIOUR_PREV_BUTTON,
    ],
    'pluginOptions' => [
        Swiper::OPTION_CENTERED_SLIDES => true,
        Swiper::OPTION_SPACE_BETWEEN => 30,
    ],
]);

?>
<style>
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
</style>