<?php

/**
 * @author relbraun <https://github.com/relbraun>
 * @source https://github.com/relbraun/yii2-repeater
 *
 * @author stop4uk <stop4uk@yandex.ru>
 * @source https://github.com/stop4uk/Yii2Repeater
 *
 * @version 1.0
 *
 * @var \yii\web\View $this
 * @var \yii\base\Model $model
 * @var int $k
 * @var string $widgetID
 * @var array $innerData
 * @var string $template
 * @var string $content
 */

if ( isset($contentPath) ) {
    $content = $this->render($contentPath, [
        'k' => $k,
        'widgetID' => $widgetID,
        'model' => $model,
        'innerData' => $innerData,
        'template' => $template,
    ]);
}

echo $content;
