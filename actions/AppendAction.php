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

namespace stop4uk\yii2repeater\actions;

use yii\base\{
    Action,
    Model
};

class AppendAction extends Action
{
    /**
     * @var Model|array|null $model
     */
    public $model;

    /**
     * @var string $contentPath
     */
    public $contentPath;

    public function run()
    {
        $this->controller->viewPath = dirname(__DIR__) . '/views';
        if ( $this->model ) {
            $model = is_array($this->model) ? $this->model : new $this->model();
        }

        $id = Yii::$app->request->post('id');
        $widgetID = Yii::$app->request->post('widgetID');
        $template = Yii::$app->request->post('template');
        $innerData = Yii::$app->request->post('innerData');

        return $this->controller->renderAjax('repeater_' . $template, [
            'k' => $id,
            'model' => $model,
            'contentPath' => $this->contentPath,
            'widgetID' => $widgetID,
            'innerData' => $innerData,
            'template' => $template,
        ]);
    }
}