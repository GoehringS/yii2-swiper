<?php

namespace renschs\yii2\swiper\tests\unit\swiper;

use renschs\yii2\swiper\tests\unit\BaseTestCase;

class SwiperDemosTest extends BaseTestCase
{

    public function test01Default()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/01-default.php'));
    }

    public function test02Responsive()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/02-responsive.php'));
    }

    public function test03Vertical()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/03-vertical.php'));
    }

    public function test04SpaceBetween()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/04-space-between.php'));
    }

    public function test05SlidesPerView()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/05-slides-per-view.php'));
    }

    public function test06SlidesPerViewAuto()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/06-slides-per-view-auto.php'));
    }

    public function test07Centered()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/07-centered.php'));
    }

    public function test08CenteredAuto()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/08-centered-auto.php'));
    }

    public function test09Freemode()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/09-freemode.php'));
    }

    public function test10SlidesPerColumn()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/10-slides-per-column.php'));
    }

    public function test11Nested()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/11-nested.php'));
    }

    public function test12GrabCursor()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/12-grab-cursor.php'));
    }

    public function test13Scrollbar()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/13-scrollbar.php'));
    }

    public function test14NavArrows()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/14-nav-arrows.php'));
    }

    public function test15InfiniteLoop()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/15-infinite-loop.php'));
    }

    public function test16EffectFade()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/16-effect-fade.php'));
    }

    public function test17EffectCube()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/17-effect-cube.php'));
    }

    public function test18EffectCoverflow()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/18-effect-coverflow.php'));
    }

    public function test19KeyboardControl()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/19-keyboard-control.php'));
    }

    public function test20MousewheelControl()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/20-mousewheel-control.php'));
    }

    public function test21Autoplay()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/21-autoplay.php'));
    }

    public function test22DynamicSlides()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/22-dynamic-slides.php'));
    }

    public function test23ThumbsGallery()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/23-thumbs-gallery.php'));
    }

    public function test24MultipleSwipers()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/24-multiple-swipers.php'));
    }

    public function test25HashNavigation()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/25-hash-navigation.php'));
    }

    public function test26Rtl()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/26-rtl.php'));
    }

    public function test27Jquery()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/27-jquery.php'));
    }

    public function test28Parallax()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/28-parallax.php'));
    }

    public function test29CustomPagination()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/29-custom-pagination.php'));
    }

    public function test30LazyLoadImages()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/30-lazy-load-images.php'));
    }

    public function test31CustomPlugin()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/31-custom-plugin.php'));
    }

    public function test32ScrollContainer()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/32-scroll-container.php'));
    }

    public function testComplex()
    {
        $this->assertNotEmpty(\Yii::$app->view->renderFile('@demos/complex.php'));
    }
}
