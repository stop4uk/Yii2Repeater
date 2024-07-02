<?php

/**
 * @author relbraun <https://github.com/relbraun>
 * @source https://github.com/relbraun/yii2-repeater
 *
 * @author stop4uk <stop4uk@yandex.ru>
 * @source https://github.com/stop4uk/Yii2Repeater
 *
 * @version 1.0
 */

namespace stop4uk\yii2repeater;

use yii\web\{
    AssetBundle,
    YiiAsset
};
use yii\bootstrap5\BootstrapPluginAsset;

class RepeaterAsset extends AssetBundle
{

    public $sourcePath = __DIR__;
    public $basePath = '@app';

    public $js = [
        'js/repeater.js',
    ];
    public $css = [
        'css/repeater.css',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
    ];
}