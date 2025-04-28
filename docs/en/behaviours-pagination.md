# Pagination

To connect these buttons you must declare behaviour `pagination` in field `\ItSolutionsSG\yii2\swiper\Swiper::$behaviours`, 
otherwise pagination will not be rendered.

> Note: to pagination was clickable, you must specify `paginationClickable = true` 
  in field `\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions`

Example:

```PHP
<?php
use ItSolutionsSG\yii2\swiper\Swiper;

echo Swiper::widget( [
  'items'         => [
    'Slide 1',
    'Slide 2',
    'Slide 3'
  ],
  'behaviours'    => [
    'pagination' // Declaration of pagination
  ],
  'pluginOptions' => [
    'paginationClickable' => true
  ]
] );

// С именованными константами
echo Swiper::widget( [
  'items'         => [
    'Slide 1',
    'Slide 2',
    'Slide 3'
  ],
  'behaviours'    => [
    Swiper::BEHAVIOUR_PAGINATION // Declaration of pagination
  ],
  'pluginOptions' => [
    Swiper::OPTION_PAGINATION_CLICKABLE => true
  ]
] );
```

## Setting pagination

You can configure pagination through the field `\ItSolutionsSG\yii2\swiper\Swiper::$paginationOptions`. 
Configuring is similar to `\yii\helpers\BaseHtml::tag`

Example:

```PHP
<?php
use ItSolutionsSG\yii2\swiper\Swiper;

echo Swiper::widget( [
  'items'         => [
    'Slide 1',
    'Slide 2',
    'Slide 3',
    'Slide 4',
    'Slide 5'
  ],
  'behaviours'    => [
    'pagination' // Declaration of pagination
  ],
  'paginationOptions'    => [
    'tag'   => 'span',
    'id'    => 'my-pagination-id',
    'class' => 'my-pagination-class',
    'data'  => [
      'id' => 'my-pagination-data-id'
    ]
  ],
  'pluginOptions' => [
    'paginationClickable' => true
  ]
] );
```

