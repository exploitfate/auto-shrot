<?php

namespace common\widgets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\widgets\ActiveForm as BaseActiveForm;

/**
 * @inheritdoc
 */
class ActiveForm extends BaseActiveForm
{
    /**
     * Runs the widget.
     */
    public function run()
    {
        $view = $this->getView();
        $formId = $this->options['id'];
        $filterSelector = "#$formId input, #$formId select";
        if (isset($this->filterSelector)) {
            $filterSelector .= ', ' . $this->filterSelector;
        }
        $registerJs =
            '$("body").on("submit","#'.$formId.'",function(e){'.
            '$.each($("'.$filterSelector.'"),function(){'.
            'var v=$(this).val();if(v=="undefined"||v==""){$(this).removeAttr("name");'.
            '}});'.
            'return true;'.
            '});';

//        if (\Yii::$app->request->isPjax) {
//            $registerJs .= '$(\'[data-toggle="tooltip"]\').tooltip();';
//        }
        $view->registerJs($registerJs);
        BootstrapPluginAsset::register($view);

        parent::run();
    }
}
