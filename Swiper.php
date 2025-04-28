<?php

declare(strict_types=1);

namespace ItSolutionsSG\yii2\swiper;

use Exception;
use ItSolutionsSG\yii2\swiper\assets\SwiperAsset;
use ItSolutionsSG\yii2\swiper\helpers\SwiperCssHelper;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * A Swiper widget is adapter to javascript Swiper slider.
 *
 * @see    http://www.idangero.us/swiper/
 */
class Swiper extends Widget
{
    /**
     * @var string[]|mixed[]|Slide[] contains information about slides
     *                               If you want to add some items in runtime,
     *                               you should use [[\ItSolutionsSG\yii2\swiper\Swiper::addItem]]
     *                               instead of direct items pushing
     *
     * @see Slide
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$itemOptions
     * @see Swiper::addItem
     * @see Swiper::renderItem
     */
    public $items = [];

    /**
     * @var mixed[] options, which first will be merged with [[\ItSolutionsSG\yii2\swiper\Slide::$options]]
     *              for each slide, and then applied in [[\yii\helpers\Html::tag]] for rendering
     *
     * @see Swiper::normalizeOptions
     * @see Swiper::renderItem
     * @see \ItSolutionsSG\yii2\swiper\Slide::$options
     */
    public $itemOptions = [];

    /**
     * @var mixed[] Options which will be applied in [[\yii\helpers\Html::tag]].
     *              If you pass the [[id]] property, it will replace auto-generated
     *              value with custom.
     *
     * @see Swiper::run
     */
    public $containerOptions = [];

    /**
     * @var mixed[] options which will be applied in [[\yii\helpers\Html::tag]]
     *
     * @see Swiper::renderWrapper
     */
    public $wrapperOptions = [];

    /**
     * @var mixed[] The key-value storage of plugin options
     *              which will be converted to JSON and
     *              applied in Swiper plugin construction
     *
     * @see Swiper::registerClientScript
     */
    public $pluginOptions = [];

    /**
     * @var string[] array of behaviours, which are required.
     *
     *               For example, if you need to include pagination, nextButton and prevButton
     *               you should declare them here
     *
     *               ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'      => ['slide01', 'slide02'],
     *                  'behaviours' => [
     *                      'pagination',
     *                      'nextButton',
     *                      'prevButton'
     *                  ]
     *               ]);
     *               ~~~
     *
     *               Also you can use named constants such as:
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_PAGINATION]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_NAVIGATION]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_SCROLLBAR]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_NEXT_BUTTON]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_PREV_BUTTON]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_RTL]]
     *               - [[\ItSolutionsSG\yii2\swiper\Swiper::BEHAVIOUR_PARALLAX]]
     *
     * @see Swiper::BEHAVIOUR_PAGINATION
     * @see Swiper::BEHAVIOUR_NAVIGATION
     * @see Swiper::BEHAVIOUR_SCROLLBAR
     * @see Swiper::BEHAVIOUR_NEXT_BUTTON
     * @see Swiper::BEHAVIOUR_PREV_BUTTON
     * @see Swiper::BEHAVIOUR_RTL
     * @see Swiper::BEHAVIOUR_PARALLAX
     */
    public $behaviours = [];

    /**
     * @var string[]
     */
    protected $availableBehaviours = [
        self::BEHAVIOUR_PAGINATION,
        self::BEHAVIOUR_NAVIGATION,
        self::BEHAVIOUR_SCROLLBAR,
        self::BEHAVIOUR_NEXT_BUTTON,
        self::BEHAVIOUR_PREV_BUTTON,
        self::BEHAVIOUR_RTL,
        self::BEHAVIOUR_PARALLAX,
    ];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] parallax item.
     *
     * @see Swiper::PARALLAX_BACKGROUND
     * @see Swiper::PARALLAX_TRANSITION
     * @see Swiper::PARALLAX_TRANSITION_X
     * @see Swiper::PARALLAX_TRANSITION_Y
     * @see Swiper::PARALLAX_DURATION
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$parallaxOptions
     * @see Swiper::renderBehaviourParallax
     */
    public const BEHAVIOUR_PARALLAX = 'parallax';
    /**
     * @see Swiper::renderBehaviourParallax
     */
    public const PARALLAX_BACKGROUND = 'background';
    /**
     * @see Swiper::renderBehaviourParallax
     */
    public const PARALLAX_TRANSITION = 'transition';
    /**
     * @see Swiper::renderBehaviourParallax
     */
    public const PARALLAX_TRANSITION_X = 'transitionX';
    /**
     * @see Swiper::renderBehaviourParallax
     */
    public const PARALLAX_TRANSITION_Y = 'transitionY';
    /**
     * @see Swiper::renderBehaviourParallax
     */
    public const PARALLAX_DURATION = 'duration';
    /**
     * @var string[] array of options which will be applied for nextButton
     *               tag rendering in [[\yii\helpers\Html::tag]]
     *
     *               For example:
     *               ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'           => ['slide01', 'slide02'],
     *                  'parallaxOptions' => [
     *                      'background'  => 'http://lorempixel.com/1920/1080/nature/1/',
     *                      'transition'  => '-23%',
     *                      'duration'    => '300'
     *                  ]
     *               ]);
     *               ~~~
     *
     * @see http://www.idangero.us/swiper/api/ - Parallax section at the bottom
     * @see  Swiper::PARALLAX_BACKGROUND
     * @see  Swiper::PARALLAX_TRANSITION
     * @see  Swiper::PARALLAX_TRANSITION_X
     * @see  Swiper::PARALLAX_TRANSITION_Y
     * @see  Swiper::PARALLAX_DURATION
     * @see  Swiper::renderBehaviourParallax
     */
    public $parallaxOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] pagination item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$paginationOptions
     * @see Swiper::renderBehaviourPagination
     */
    public const BEHAVIOUR_PAGINATION = 'pagination';
    /**
     * @var mixed[] array of options which will be applied for pagination
     *              tag rendering in [[\yii\helpers\Html::tag]]
     *
     *              ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'             => ['slide01', 'slide02'],
     *                  'paginationOptions' => [
     *                      'class' => 'swiper-pagination-white',
     *                      'id'    => 'my-swiper-pagination-id',
     *                      'data'  => [
     *                          'parameter' => 'my-custom-parameter'
     *                      ]
     *                  ]
     *               ]);
     *              ~~~
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$scrollbarOptions
     */
    public $paginationOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] pagination item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$navigationOptions
     * @see Swiper::renderBehaviourNavigation
     */
    public const BEHAVIOUR_NAVIGATION = 'navigation';
    /**
     * @var mixed[] array of options which will be applied for navigation
     *              tag rendering in [[\yii\helpers\Html::tag]]
     *
     *              ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'             => ['slide01', 'slide02'],
     *                  'navigationOptions' => [
     *                      'nextEl' => '#',
     *                      'prevEl' => '#',
     *                  ]
     *               ]);
     *              ~~~
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$scrollbarOptions
     */
    public $navigationOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] scrollbar item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$scrollbarOptions
     * @see Swiper::renderBehaviourScrollbar
     */
    public const BEHAVIOUR_SCROLLBAR = 'scrollbar';
    /**
     * @var mixed[] array of options which will be applied for scrollbar
     *              tag rendering in [[\yii\helpers\Html::tag]]
     *
     *              ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'            => ['slide01', 'slide02'],
     *                  'scrollbarOptions' => [
     *                      'class' => 'my-custom-scrollbar-class',
     *                      'id'    => 'my-swiper-scrollbar-id',
     *                      'data'  => [
     *                          'parameter' => 'my-custom-parameter'
     *                      ]
     *                  ]
     *               ]);
     *              ~~~
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$paginationOptions
     */
    public $scrollbarOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] nextButton item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$nextButtonOptions
     * @see Swiper::renderBehaviourNextButton
     */
    public const BEHAVIOUR_NEXT_BUTTON = 'nextButton';
    /**
     * @var mixed[] array of options which will be applied for nextButton
     *              tag rendering in [[\yii\helpers\Html::tag]]
     *
     *              ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'             => ['slide01', 'slide02'],
     *                  'nextButtonOptions' => [
     *                      'class' => 'my-custom-next-button-class',
     *                      'id'    => 'my-swiper-next-button-id',
     *                      'data'  => [
     *                          'parameter' => 'my-custom-parameter'
     *                      ]
     *                  ]
     *               ]);
     *              ~~~
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$prevButtonOptions
     */
    public $nextButtonOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] prevButton item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$prevButtonOptions
     * @see Swiper::renderBehaviourPrevButton
     */
    public const BEHAVIOUR_PREV_BUTTON = 'prevButton';
    /**
     * @var mixed[] array of options which will be applied for prevButton
     *              tag rendering in [[\yii\helpers\Html::tag]]
     *
     *              ~~~
     *               \ItSolutionsSG\yii2\swiper\Swiper::widget([
     *                  'items'             => ['slide01', 'slide02'],
     *                  'nextButtonOptions' => [
     *                      'class' => 'my-custom-prev-button-class',
     *                      'id'    => 'my-swiper-prev-button-id',
     *                      'data'  => [
     *                          'parameter' => 'my-custom-parameter'
     *                      ]
     *                  ]
     *               ]);
     *              ~~~
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$nextButtonOptions
     */
    public $prevButtonOptions = [];

    /**
     * Named alias for [[\ItSolutionsSG\yii2\swiper\Swiper::$behaviours]] rtl item.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$behaviours
     * @see Swiper::setBehaviourRtl
     */
    public const BEHAVIOUR_RTL = 'rtl';

    /**
     * This function is batch-wrapper of \ItSolutionsSG\yii2\swiper\Swiper::addItem.
     *
     * @param string[]|mixed[][]|Slide[] $items batch of items
     *                                          to be added into slider
     *
     * @see Swiper::addItem
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$items
     * @see Slide
     *
     * @return Swiper
     */
    public function addItems(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * If you wants to add an item to collection in runtime,
     * you should use this instead of direct items pushing to collection,
     * because it supports configuring slides from strings and arrays.
     *
     * Also it merges [[\ItSolutionsSG\yii2\swiper\Swiper::$itemOptions]]
     * with concrete item options.
     *
     * @param string|mixed[]|Slide $item the content, or configuration,
     *                                   or [[\ItSolutionsSG\yii2\swiper\Slide]] itself
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$items
     * @see Slide
     *
     * @return Swiper
     */
    public function addItem($item = [])
    {
        $this->items[] = $this->normalizeItem($item, count($this->items));

        return $this;
    }

    public function run()
    {
        $contentPieces = [
            $this->renderBehaviourParallax(),
            $this->renderWrapper(),
            $this->renderBehaviourNavigation(),
            $this->renderBehaviourScrollbar(),
            $this->renderBehaviourNextButton(),
            $this->renderBehaviourPrevButton(),
            $this->renderBehaviourPagination(),
        ];

        $this->setBehaviourRtl();

        $this->registerClientScript();

        $containerOptions = $this->containerOptions;
        $containerTag = ArrayHelper::remove($containerOptions, 'tag', 'div');
        $renderedContainer = Html::tag($containerTag, implode(PHP_EOL, $contentPieces), $containerOptions);

        return $renderedContainer;
    }

    /**
     * This function check if there is wrong behaviours
     * and call normalizing of items and every options.
     *
     * @see Swiper::checkBehaviours
     * @see Swiper::normalizeOptions
     * @see Swiper::normalizeItems
     */
    public function init()
    {
        $this->checkBehaviours();

        $this->normalizeOptions();
        $this->normalizeItems();
    }

    /**
     * This function sets default values to options of widget
     * such as [[id]] and [[class]].
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$containerOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$wrapperOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$paginationOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$scrollbarOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$nextButtonOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$prevButtonOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$parallaxOptions
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$itemOptions
     */
    protected function normalizeOptions()
    {
        $id = ArrayHelper::getValue($this->containerOptions, 'id', $this->getId());

        // @formatter:off

        $this->itemOptions['options'] = ArrayHelper::getValue($this->itemOptions, 'options', []);
        $this->itemOptions['options']['data'] = ArrayHelper::getValue($this->itemOptions['options'], 'data', []);
        $this->itemOptions['options']['class'] = trim(ArrayHelper::getValue($this->itemOptions['options'], 'class', '').' swiper-slide', ' ');

        $this->containerOptions['id'] = $id;
        $this->containerOptions['class'] = trim(ArrayHelper::getValue($this->containerOptions, 'class', '').' swiper-container', ' ');

        $this->wrapperOptions['id'] = ArrayHelper::getValue($this->wrapperOptions, 'id', "{$id}-wrapper");
        $this->wrapperOptions['class'] = trim(ArrayHelper::getValue($this->wrapperOptions, 'class', '').' swiper-wrapper', ' ');

        $this->paginationOptions['id'] = ArrayHelper::getValue($this->paginationOptions, 'id', "{$id}-pagination");
        $this->paginationOptions['class'] = trim(ArrayHelper::getValue($this->paginationOptions, 'class', '').' swiper-pagination', ' ');

        $this->scrollbarOptions['id'] = ArrayHelper::getValue($this->scrollbarOptions, 'id', "{$id}-scrollbar");
        $this->scrollbarOptions['class'] = trim(ArrayHelper::getValue($this->scrollbarOptions, 'class', '').' swiper-scrollbar', ' ');

        $this->nextButtonOptions['id'] = ArrayHelper::getValue($this->nextButtonOptions, 'id', "{$id}-swiper-button-next");
        $this->nextButtonOptions['class'] = trim(ArrayHelper::getValue($this->nextButtonOptions, 'class', '').' swiper-button-next', ' ');

        $this->prevButtonOptions['id'] = ArrayHelper::getValue($this->prevButtonOptions, 'id', "{$id}-swiper-button-prev");
        $this->prevButtonOptions['class'] = trim(ArrayHelper::getValue($this->prevButtonOptions, 'class', '').' swiper-button-prev', ' ');

        $this->parallaxOptions['id'] = ArrayHelper::getValue($this->parallaxOptions, 'id', "{$id}-parallax");
        $this->parallaxOptions['class'] = trim(ArrayHelper::getValue($this->parallaxOptions, 'class', '').' parallax-bg', ' ');
        $this->parallaxOptions['data'] = ArrayHelper::getValue($this->parallaxOptions, 'data', []);

        /*
         * Parallax options, specified via shorthands, have more priority
         * than directly specified options
         */
        $this->parallaxOptions['data']['swiper-parallax'] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax', null));
        $this->parallaxOptions['data']['swiper-parallax-x'] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION_X, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-x', null));
        $this->parallaxOptions['data']['swiper-parallax-y'] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION_Y, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-y', null));
        $this->parallaxOptions['data']['swiper-parallax-duration'] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_DURATION, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-duration', null));

        $this->parallaxOptions[self::PARALLAX_TRANSITION] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax', null));
        $this->parallaxOptions[self::PARALLAX_TRANSITION_X] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION_X, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-x', null));
        $this->parallaxOptions[self::PARALLAX_TRANSITION_Y] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_TRANSITION_Y, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-y', null));
        $this->parallaxOptions[self::PARALLAX_DURATION] = ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_DURATION, ArrayHelper::getValue($this->parallaxOptions['data'], 'swiper-parallax-duration', null));

        $this->parallaxOptions['data'] = array_filter($this->parallaxOptions['data']);

        // @formatter:on

        if (ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_BACKGROUND)) {
            $this->parallaxOptions['style'] = SwiperCssHelper::mergeStyleAndBackground(
                ArrayHelper::getValue($this->parallaxOptions, self::PARALLAX_BACKGROUND, ''),
                ArrayHelper::getValue($this->parallaxOptions, 'style', '')
            );
        } elseif (ArrayHelper::getValue($this->parallaxOptions, 'style')) {
            $this->parallaxOptions[self::PARALLAX_BACKGROUND] = SwiperCssHelper::getBackgroundUrl(
                $this->parallaxOptions['style']
            );
        }
    }

    /**
     * This function converts non-[[\ItSolutionsSG\yii2\swiper\Slide]] items
     * to [[\ItSolutionsSG\yii2\swiper\Slide]] respectively.
     *
     * Then it merges [[\ItSolutionsSG\yii2\swiper\Swiper::$itemOptions]] with
     * concrete item options
     */
    protected function normalizeItems()
    {
        foreach ($this->items as $index => $item) {
            $this->items[$index] = $this->normalizeItem($item, $index);
        }
    }

    /**
     * This function converts non-[[\ItSolutionsSG\yii2\swiper\Slide]] item
     * to [[\ItSolutionsSG\yii2\swiper\Slide]], merging batch options,
     * automatically sets id and class and so on...
     *
     * @param string|mixed[]|Slide $item
     * @param int                  $index
     *
     * @return Slide
     */
    protected function normalizeItem($item, $index)
    {
        /*
         * If concrete \ItSolutionsSG\yii2\swiper\Slide given
         * then it is meant to be fully custom-configured
         * and it will not be managed there.
         */
        if ($item instanceof Slide) {
            return $item;
        }

        $item = is_string($item)
            ? ['content' => $item]
            : $item;

        $itemOptions = $this->itemOptions;

        /*
         * Id must be unique and batch value cannot be applied
         */
        ArrayHelper::remove($itemOptions['options'], 'id');
        /*
         * Hash must be unique too
         */
        ArrayHelper::remove($itemOptions, 'hash');
        ArrayHelper::remove($itemOptions['options']['data'], 'hash');

        $item['options'] = ArrayHelper::getValue($item, 'options', []);

        $itemClass = ArrayHelper::getValue($item['options'], 'class', '');
        $item['options']['id'] = ArrayHelper::getValue($item['options'], 'id', "{$this->containerOptions['id']}-slide-{$index}");
        $item['options']['class'] = trim(ArrayHelper::getValue($itemOptions['options'], 'class', '')." {$itemClass}", ' ');

        $item = array_replace_recursive($itemOptions, $item);

        return new Slide($item);
    }

    /**
     * Checks if there is invalid behaviour given.
     * If given, then throws exception.
     *
     * @throws \InvalidArgumentException
     */
    protected function checkBehaviours()
    {
        foreach ($this->behaviours as $behaviour) {
            if (!in_array($behaviour, $this->availableBehaviours)) {
                throw new \InvalidArgumentException("Unknown behaviour {$behaviour}");
            }
        }
    }

    /**
     * This function renders parallax part of widget.
     *
     * More information about parallax you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see http://www.idangero.us/swiper/api/ - Parallax section at the bottom
     * @see  Swiper::PARALLAX_BACKGROUND
     * @see  Swiper::PARALLAX_TRANSITION
     * @see  Swiper::PARALLAX_TRANSITION_X
     * @see  Swiper::PARALLAX_TRANSITION_Y
     * @see  Swiper::PARALLAX_DURATION
     * @see  \ItSolutionsSG\yii2\swiper\Swiper::$parallaxOptions
     *
     * @return string
     */
    protected function renderBehaviourParallax()
    {
        if (!in_array(self::BEHAVIOUR_PARALLAX, $this->behaviours)) {
            return '';
        }

        $parallaxOptions = $this->parallaxOptions;
        $parallaxTag = ArrayHelper::remove($parallaxOptions, 'tag', 'div');

        ArrayHelper::remove($parallaxOptions, self::PARALLAX_BACKGROUND);
        ArrayHelper::remove($parallaxOptions, self::PARALLAX_TRANSITION);
        ArrayHelper::remove($parallaxOptions, self::PARALLAX_TRANSITION_X);
        ArrayHelper::remove($parallaxOptions, self::PARALLAX_TRANSITION_Y);
        ArrayHelper::remove($parallaxOptions, self::PARALLAX_DURATION);

        return Html::tag($parallaxTag, '', $parallaxOptions);
    }

    /**
     * This function renders pagination part of widget.
     *
     * More information about pagination you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_PAGINATION
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$paginationOptions
     * @see Swiper::renderBehaviourScrollbar
     *
     * @return string
     */
    protected function renderBehaviourPagination()
    {
        if (in_array(self::BEHAVIOUR_PAGINATION, $this->behaviours)) {
            $paginationOptions = $this->paginationOptions;
            $paginationTag = ArrayHelper::remove($paginationOptions, 'tag', 'div');

            if (!isset($this->pluginOptions[self::OPTION_PAGINATION]['id'])) {
                $this->pluginOptions[self::OPTION_PAGINATION]['el'] = '#'.$paginationOptions['id'];
            }

            if (!isset($this->pluginOptions[self::OPTION_PAGINATION][self::OPTION_PAGINATION_CLICKABLE])) {
                $this->pluginOptions[self::OPTION_PAGINATION]['clickable'] = false;
            } else {
                if (!is_bool($this->pluginOptions[self::OPTION_PAGINATION][self::OPTION_PAGINATION_CLICKABLE])) {
                    throw new \Exception('Pagination clickable option must be boolean');
                }

                $this->pluginOptions[self::OPTION_PAGINATION]['clickable'] = $this->pluginOptions[self::OPTION_PAGINATION][self::OPTION_PAGINATION_CLICKABLE];
                unset($this->pluginOptions[self::OPTION_PAGINATION][self::OPTION_PAGINATION_CLICKABLE]);
            }

            // print_r($this->pluginOptions);
            // die();

            return Html::tag($paginationTag, '', $paginationOptions);
        }

        return '';
    }

    /**
     * This function renders navigation part of widget.
     *
     * More information about navigation you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_PAGINATION
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$prevButtonOptions
     * @see Swiper::renderBehaviourScrollbar
     *
     * @return string
     */
    protected function renderBehaviourNavigation()
    {
        if (in_array(self::BEHAVIOUR_NAVIGATION, $this->behaviours)) {
            $navigationOptions = $this->navigationOptions;
            $navigationTag = ArrayHelper::remove($navigationOptions, 'tag', 'div');

            if (!isset($this->pluginOptions[self::OPTION_NAVIGATION])) {
                $this->pluginOptions[self::OPTION_NAVIGATION] = [
                    self::OPTION_NEXT_BUTTON => $this->nextButtonOptions['id'],
                    self::OPTION_PREV_BUTTON => $this->prevButtonOptions['id'],
                ];
            }

            return Html::tag($navigationTag, '', $navigationOptions);
        }

        return '';
    }

    /**
     * This function renders scrollbar part of widget.
     *
     * More information about scrollbar you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_SCROLLBAR
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$scrollbarOptions
     * @see Swiper::renderBehaviourPagination
     *
     * @return string
     */
    protected function renderBehaviourScrollbar()
    {
        if (in_array(self::BEHAVIOUR_SCROLLBAR, $this->behaviours)) {
            $scrollbarOptions = $this->scrollbarOptions;
            $scrollbarTag = ArrayHelper::remove($scrollbarOptions, 'tag', 'div');

            if (!isset($this->pluginOptions[self::OPTION_SCROLLBAR])) {
                $this->pluginOptions[self::OPTION_SCROLLBAR] = '#'.$scrollbarOptions['id'];
            }

            return Html::tag($scrollbarTag, '', $scrollbarOptions);
        }

        return '';
    }

    /**
     * This function renders nextButton part of widget.
     *
     * More information about nextButton you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_NEXT_BUTTON
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$nextButtonOptions
     * @see Swiper::renderBehaviourPrevButton
     *
     * @return string
     */
    protected function renderBehaviourNextButton()
    {
        if (in_array(self::BEHAVIOUR_NAVIGATION, $this->behaviours) && in_array(self::BEHAVIOUR_NEXT_BUTTON, $this->behaviours)) {
            $nextButtonOptions = $this->nextButtonOptions;
            $nextButtonTag = ArrayHelper::remove($nextButtonOptions, 'tag', 'div');

            if (!isset($this->pluginOptions[self::OPTION_NEXT_BUTTON])) {
                $this->pluginOptions[self::OPTION_NAVIGATION][self::OPTION_NEXT_BUTTON] = '#'.$nextButtonOptions['id'];
            }

            return Html::tag($nextButtonTag, '', $nextButtonOptions);
        }

        return '';
    }

    /**
     * This function renders prevButton part of widget.
     *
     * More information about prevButton you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_PREV_BUTTON
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$prevButtonOptions
     * @see Swiper::renderBehaviourNextButton
     *
     * @return string
     */
    protected function renderBehaviourPrevButton()
    {
        if (in_array(self::BEHAVIOUR_NAVIGATION, $this->behaviours) && in_array(self::BEHAVIOUR_PREV_BUTTON, $this->behaviours)) {
            $prevButtonOptions = $this->prevButtonOptions;
            $prevButtonTag = ArrayHelper::remove($prevButtonOptions, 'tag', 'div');

            if (!isset($this->pluginOptions[self::OPTION_PREV_BUTTON])) {
                $this->pluginOptions[self::OPTION_NAVIGATION][self::OPTION_PREV_BUTTON] = '#'.$prevButtonOptions['id'];
            }

            return Html::tag($prevButtonTag, '', $prevButtonOptions);
        }

        return '';
    }

    /**
     * This function adds [[dir=rtl]] tag option to [[\ItSolutionsSG\yii2\swiper\Swiper::$containerOptions]].
     *
     * More information about rtl you can find
     * in official site of plugin - http://www.idangero.us/swiper/api/
     *
     * Also you can find some examples in [[~/yii2-swiper/demos]] folder
     *
     * @see Swiper::BEHAVIOUR_RTL
     *
     * @return Swiper
     */
    protected function setBehaviourRtl()
    {
        if (in_array(self::BEHAVIOUR_RTL, $this->behaviours)) {
            $this->containerOptions['dir'] = 'rtl';
        }

        return $this;
    }

    /**
     * This function renders the wrapper tag of swiper,
     * which contains slides.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$wrapperOptions
     * @see Swiper::renderItems
     *
     * @return string
     */
    protected function renderWrapper()
    {
        $renderedItems = $this->renderItems($this->items);

        $wrapperOptions = $this->wrapperOptions;
        $wrapperTag = ArrayHelper::remove($wrapperOptions, 'tag', 'div');
        $renderedWrapper = Html::tag($wrapperTag, PHP_EOL.$renderedItems.PHP_EOL, $wrapperOptions);

        return PHP_EOL.$renderedWrapper.PHP_EOL;
    }

    /**
     * This function just calls [[\ItSolutionsSG\yii2\swiper\Swiper::renderItem]]
     * for each [[\ItSolutionsSG\yii2\swiper\Swiper::$items]] and returns
     * formatter result.
     *
     * @param Slide[] $items
     *
     * @return string
     */
    protected function renderItems(array $items)
    {
        $renderedItems = [];
        foreach ($items as $index => $item) {
            $renderedItems[] = $this->renderItem($item);
        }

        return implode(PHP_EOL, $renderedItems);
    }

    /**
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$items
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$itemOptions
     *
     * @return string
     */
    protected function renderItem(Slide $slide)
    {
        $options = $slide->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::tag($tag, $slide->content, $options);
    }

    /**
     * Registers the initializer of Swiper plugin.
     *
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     *
     * @return Swiper
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        SwiperAsset::register($view);

        $id = $this->containerOptions['id'];
        $pluginOptions = Json::encode($this->pluginOptions);
        $variableName = 'swiper'.Inflector::id2camel($this->containerOptions['id']);

        $view->registerJs(
            new JsExpression(
                <<<JS
        //noinspection JSUnnecessarySemicolon
        ;var {$variableName} = new Swiper('#{$id}', {$pluginOptions});
JS
            )
        );

        return $this;
    }

    // <editor-fold desc="Named constants for Swiper options">

    public const OPTION_INITIAL_SLIDE = 'initialSlide';
    public const OPTION_DIRECTION = 'direction';
    public const OPTION_SPEED = 'speed';
    public const OPTION_SET_WRAPPER_SIZE = 'setWrapperSize';
    public const OPTION_VIRTUAL_TRANSLATE = 'virtualTranslate';
    public const OPTION_WIDTH = 'width';
    public const OPTION_HEIGHT = 'height';
    public const OPTION_AUTOPLAY = 'autoplay';
    public const OPTION_AUTOPLAY_DISABLE_ON_INTERACTION = 'autoplayDisableOnInteraction';
    public const OPTION_WATCH_SLIDES_PROGRESS = 'watchSlidesProgress';
    public const OPTION_WATCH_SLIDES_VISIBILITY = 'watchSlidesVisibility';
    public const OPTION_FREE_MODE = 'freeMode';
    public const OPTION_FREE_MODE_MOMENTUM = 'freeModeMomentum';
    public const OPTION_FREE_MODE_MOMENTUM_RATIO = 'freeModeMomentumRatio';
    public const OPTION_FREE_MODE_MOMENTUM_BOUNCE = 'freeModeMomentumBounce';
    public const OPTION_FREE_MODE_MOMENTUM_BOUNCE_RATIO = 'freeModeMomentumBounceRatio';
    public const OPTION_FREE_MODE_STICKY = 'freeModeSticky';
    public const OPTION_EFFECT = 'effect';
    public const OPTION_FADE = 'fade';
    public const OPTION_FADE_CROSS_FADE = 'crossFade';
    public const OPTION_CUBE = 'cube';
    public const OPTION_CUBE_SLIDE_SHADOWS = 'slideShadows';
    public const OPTION_CUBE_SHADOW = 'shadow';
    public const OPTION_CUBE_SHADOW_OFFSET = 'shadowOffset';
    public const OPTION_CUBE_SHADOW_SCALE = 'shadowScale';
    public const OPTION_COVERFLOW = 'coverflow';
    public const OPTION_COVERFLOW_ROTATE = 'rotate';
    public const OPTION_COVERFLOW_STRETCH = 'stretch';
    public const OPTION_COVERFLOW_DEPTH = 'depth';
    public const OPTION_COVERFLOW_MODIFIER = 'modifier';
    public const OPTION_COVERFLOW_SLIDE_SHADOWS = 'slideShadows';
    public const OPTION_PARALLAX = 'parallax';
    public const OPTION_SPACE_BETWEEN = 'spaceBetween';
    public const OPTION_SLIDES_PER_VIEW = 'slidesPerView';
    public const OPTION_SLIDES_PER_COLUMN = 'slidesPerColumn';
    public const OPTION_SLIDES_PER_COLUMN_FILL = 'slidesPerColumnFill';
    public const OPTION_SLIDES_PER_GROUP = 'slidesPerGroup';
    public const OPTION_CENTERED_SLIDES = 'centeredSlides';
    public const OPTION_GRAB_CURSOR = 'grabCursor';
    public const OPTION_TOUCH_RATIO = 'touchRatio';
    public const OPTION_TOUCH_ANGLE = 'touchAngle';
    public const OPTION_SIMULATE_TOUCH = 'simulateTouch';
    public const OPTION_SHORT_SWIPES = 'shortSwipes';
    public const OPTION_LONG_SWIPES = 'longSwipes';
    public const OPTION_LONGS_WIPES_RATIO = 'longSwipesRatio';
    public const OPTION_LONG_SWIPES_MS = 'longSwipesMs';
    public const OPTION_FOLLOW_FINGER = 'followFinger';
    public const OPTION_ONLY_EXTERNAL = 'onlyExternal';
    public const OPTION_THRESHOLD = 'threshold';
    public const OPTION_TOUCH_MOVE_STOP_PROPAGATION = 'touchMoveStopPropagation';
    public const OPTION_RESISTANCE = 'resistance';
    public const OPTION_RESISTANCE_RATIO = 'resistanceRatio';
    public const OPTION_PREVENT_CLICKS = 'preventClicks';
    public const OPTION_PREVENT_CLICKS_PROPAGATION = 'preventClicksPropagation';
    public const OPTION_SLIDE_TO_CLICKED_SLIDE = 'slideToClickedSlide';
    public const OPTION_ALLOW_SWIPE_TO_PREV = 'allowSwipeToPrev';
    public const OPTION_ALLOW_SWIPE_TO_NEXT = 'allowSwipeToNext';
    public const OPTION_NO_SWIPING = 'noSwiping';
    public const OPTION_NO_SWIPING_CLASS = 'noSwipingClass';
    public const OPTION_SWIPE_HANDLER = 'swipeHandler';
    public const OPTION_PAGINATION = 'pagination';
    public const OPTION_PAGINATION_HIDE = 'paginationHide';
    public const OPTION_PAGINATION_CLICKABLE = 'paginationClickable';
    public const OPTION_PAGINATION_BULLET_RENDER = 'paginationBulletRender';
    public const OPTION_NAVIGATION = 'navigation';
    public const OPTION_NEXT_BUTTON = 'nextEl';
    public const OPTION_PREV_BUTTON = 'prevEl';
    public const OPTION_A11Y = 'a11y';
    public const OPTION_PREV_SLIDE_MESSAGE = 'prevSlideMessage';
    public const OPTION_NEXT_SLIDE_MESSAGE = 'nextSlideMessage';
    public const OPTION_FIRST_SLIDE_MESSAGE = 'firstSlideMessage';
    public const OPTION_LAST_SLIDE_MESSAGE = 'lastSlideMessage';
    public const OPTION_SCROLLBAR = 'scrollbar';
    public const OPTION_SCROLLBAR_HIDE = 'scrollbarHide';
    public const OPTION_KEYBOARD_CONTROL = 'keyboardControl';
    public const OPTION_MOUSEWHEEL_CONTROL = 'mousewheelControl';
    public const OPTION_MOUSEWHEEL_FORCE_TO_AXIS = 'mousewheelForceToAxis';
    public const OPTION_MOUSEWHEEL_RELEASE_ON_EDGES = 'mousewheelReleaseOnEdges';
    public const OPTION_MOUSEWHEEL_INVERT = 'mousewheelInvert';
    public const OPTION_HASHNAV = 'hashnav';
    public const OPTION_PRELOAD_IMAGES = 'preloadImages';
    public const OPTION_UPDATE_ON_IMAGES_READY = 'updateOnImagesReady';
    public const OPTION_LAZY_LOADING = 'lazyLoading';
    public const OPTION_LAZY_LOADING_IN_PREV_NEXT = 'lazyLoadingInPrevNext';
    public const OPTION_LAZY_LOADING_ON_TRANSITION_START = 'lazyLoadingOnTransitionStart';
    public const OPTION_LOOP = 'loop';
    public const OPTION_LOOP_ADDITIONAL_SLIDES = 'loopAdditionalSlides';
    public const OPTION_LOOPED_SLIDES = 'loopedSlides';
    public const OPTION_CONTROL = 'control';
    public const OPTION_CONTROL_INVERSE = 'controlInverse';
    public const OPTION_OBSERVER = 'observer';
    public const OPTION_OBSERVE_PARENTS = 'observeParents';
    public const OPTION_RUN_CALLBACKS_ON_INIT = 'runCallbacksOnInit';
    public const OPTION_ON_INIT = 'onInit';
    public const OPTION_ON_SLIDE_CHANGE_START = 'onSlideChangeStart';
    public const OPTION_ON_SLIDE_CHANGE_END = 'onSlideChangeEnd';
    public const OPTION_ON_TRANSITION_START = 'onTransitionStart';
    public const OPTION_ON_TRANSITION_END = 'onTransitionEnd';
    public const OPTION_ON_TOUCH_START = 'onTouchStart';
    public const OPTION_ON_TOUCH_MOVE = 'onTouchMove';
    public const OPTION_ON_TOUCH_MOVE_OPPOSITE = 'onTouchMoveOpposite';
    public const OPTION_ON_SLIDER_MOVE = 'onSliderMove';
    public const OPTION_ON_TOUCH_END = 'onTouchEnd';
    public const OPTION_ON_CLICK = 'onClick';
    public const OPTION_ON_TAP = 'onTap';
    public const OPTION_ON_DOUBLE_TAP = 'onDoubleTap';
    public const OPTION_ON_IMAGES_READY = 'onImagesReady';
    public const OPTION_ON_PROGRESS = 'onProgress';
    public const OPTION_ON_REACH_BEGINNING = 'onReachBeginning';
    public const OPTION_ON_REACH_END = 'onReachEnd';
    public const OPTION_ON_DESTROY = 'onDestroy';
    public const OPTION_ON_SET_TRANSLATE = 'onSetTranslate';
    public const OPTION_ON_SET_TRANSITION = 'onSetTransition';
    public const OPTION_ON_AUTOPLAY_START = 'onAutoplayStart';
    public const OPTION_ON_AUTOPLAY_STOP = 'onAutoplayStop';
    public const OPTION_ON_LAZY_IMAGE_LOAD = 'onLazyImageLoad';
    public const OPTION_ON_LAZY_IMAGE_READY = 'onLazyImageReady';
    public const OPTION_SLIDE_CLASS = 'slideClass';
    public const OPTION_SLIDE_ACTIVE_CLASS = 'slideActiveClass';
    public const OPTION_SLIDE_VISIBLE_CLASS = 'slideVisibleClass';
    public const OPTION_SLIDE_DUPLICATE_CLASS = 'slideDuplicateClass';
    public const OPTION_SLIDE_NEXT_CLASS = 'slideNextClass';
    public const OPTION_SLIDE_PREV_CLASS = 'slidePrevClass';
    public const OPTION_WRAPPER_CLASS = 'wrapperClass';
    public const OPTION_BULLET_CLASS = 'bulletClass';
    public const OPTION_BULLET_ACTIVE_CLASS = 'bulletActiveClass';
    public const OPTION_PAGINATION_HIDDEN_CLASS = 'paginationHiddenClass';
    public const OPTION_BUTTON_DISABLED_CLASS = 'buttonDisabledClass';

    /**
     * Named alias for [[direction]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_DIRECTION
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const DIRECTION_HORIZONTAL = 'horizontal';
    /**
     * Named alias for [[direction]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_DIRECTION
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const DIRECTION_VERTICAL = 'vertical';

    /**
     * Named alias for [[effect]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_EFFECT
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const EFFECT_FADE = 'fade';
    /**
     * Named alias for [[effect]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_EFFECT
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const EFFECT_CUBE = 'cube';
    /**
     * Named alias for [[effect]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_EFFECT
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const EFFECT_COVERFLOW = 'coverflow';

    /**
     * Named alias for [[slidesPerView]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_SLIDES_PER_VIEW
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const SLIDES_PER_VIEW_AUTO = 'auto';

    /**
     * Named alias for [[slidesPerColumnFill]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_SLIDES_PER_COLUMN_FILL
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const SLIDES_PER_COLUMN_FILL_COLUMN = 'column';
    /**
     * Named alias for [[slidesPerColumnFill]] option
     * in [[\ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions]].
     *
     * @see Swiper::OPTION_SLIDES_PER_COLUMN_FILL
     * @see \ItSolutionsSG\yii2\swiper\Swiper::$pluginOptions
     */
    public const SLIDES_PER_COLUMN_FILL_ROW = 'row';

    // </editor-fold>
}
