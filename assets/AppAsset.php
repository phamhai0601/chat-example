<?php
/**
 * @see http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css',
        'css/site.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js',
        'https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js',
        'https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
