<?php

/**
 * @author relbraun <https://github.com/relbraun>
 * @author stop4uk <stop4uK@yandex.ru>
 * @version 1.0
 */

namespace stop4uk\yii2repeater;

use Yii;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

class Repeater extends Widget
{
    const TEMPLATE_DIV = 'div';
    const TEMPLATE_TABLE = 'table';

    /**
     * @var int|string
     */
    public $id;
    /**
     * @var string
     */
    public string $template = self::TEMPLATE_DIV;
    /**
     * @var string The view path to render repeater
     */
    public string $modelView;
    /**
     * @var string The new item action url to run in ajax
     */
    public string $appendAction;
    /**
     * @var string The remove item action url to run in ajax
     */
    public string $removeAction;
    /**
     * @var ActiveRecord[]|array
     */
    public $models;
    /**
     * @var ActiveForm Optional, if you want to use the $form variable.
     */
    public $form;
    /**
     * @var array Key - value params to append to the view file
     */
    public $additionalData = [];
    /**
     * @var string
     */
    public $addButtonBlockClass;
    /**
     * @var string
     */
    public $addButtonName;
    /**
     * @var string
     */
    public $addButtonClass;
    /**
     * @var string
     */
    private $_data;

    public function init()
    {
        parent::init();

        if ( !$this->id ) {
            $this->id = Yii::$app->getSecurity()->generateRandomKey(6);
        }

        if ( !$this->addButtonBlockClass ) {
            $this->addButtonBlockClass = 'mt-3';
        }

        if ( !$this->addButtonName ) {
            $this->addButtonName = 'Add new item';
        }

        if ( $this->addButtonClass ) {
            $this->addButtonClass = 'btn btn-dark';
        }

        $this->_data = Json::encode([
            'widgetID' => $this->id,
            'append' => $this->appendAction,
            'remove' => $this->removeAction,
            'template' => $this->template,
            'additionalInformation' => $this->additionalInformation,
        ]);
    }

    public function beforeRun(): bool
    {
        if ( !parent::beforeRun() ) {
            return false;
        }

        $view = $this->getView();
        RepeaterAsset::register($view);

        return true;
    }

    public function run()
    {
        switch ($this->template) {
            case self::TEMPLATE_DIV:
                $this->renderByDiv();
                break;
            case self::TEMPLATE_TABLE:
                $this->renderByTable();
                break;
        }
    }

    private function renderByDiv()
    {
        echo Html::beginTag('div', ['class' => 'ab_repeater_' . $this->id]);
        echo Html::tag('div', $this->generateContent(), ['class' => 'list-area']);
        echo Html::tag(
            'div',
            Html::button($this->addButtonName, [
                'type' => 'button',
                'id' => 'new-repeater_' . $this->id,
                'class' => $this->addButtonClass . ' new-repeater_' . $this->id,
            ]),
            [
                'class' => $this->addButtonBlockClass
            ]);
        echo Html::endTag('div');
        $this->registerRepeater();
    }

    private function renderByTable()
    {
        $this->generateContent();
        $this->registerRepeater();
    }

    private function generateContent(): void
    {
        foreach($this->models as $k => $model) {
            $key = $k ?? 0;

            $content = $this->render($this->modelView, array_merge([
                'k' => $key,
                'model' => $model,
                'form' => $this->form,
                'widgetID' => $this->id,
            ], $this->additionalData));

            echo $this->render('repeater_div', [
                'k' => $key,
                'model' => $model,
                'content' => $content,
                'widgetID' => $this->id,
            ]);
        }
    }

    private function registerRepeater(): void
    {
        $js = "new window.repeater($this->_data)";
        $this->view->registerJs($js);
    }
}
