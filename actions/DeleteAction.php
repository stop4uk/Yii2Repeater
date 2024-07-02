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

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\db\ActiveRecord;

class DeleteAction extends Action
{
    /**
     * @var ActiveRecord|string
     */
    public $model;

    /**
     * @var bool When need delete record from DB using model
     */
    public bool $removeFromDB = false;

    public function run()
    {
        $id = Yii::$app->request->post('id');
        $response = 1;
        if ( $this->removeFromDB ) {
            $model = $this->model;
            $model = $model::findOne($id);
            $response = 0;

            if( $model ){
                $response = $model->delete();
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => $response];
    }
}
