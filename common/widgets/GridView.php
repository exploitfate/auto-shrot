<?php

namespace common\widgets;

use common\models\DataColumn;
use yii\bootstrap\BootstrapPluginAsset;
use yii\grid\GridView as BaseGridView;

/**
 * @inheritdoc
 */
class GridView extends BaseGridView
{

    /**
     * @inheritdoc
     */
    public $options = ['class' => 'grid-view table-responsive'];

    /**
     * @inheritdoc
     */
    public $tableOptions = ['class' => 'table table-striped table-bordered table-condensed'];

    /**
     * @inheritdoc
     */
    public $dataColumnClass = DataColumn::class;

    /**
     * @inheritdoc
     */
    public $pager = ['class' => LinkPager::class];

    /**
     * @inheritdoc
     */
    public $summaryOptions = ['class' => 'summary'];

    /**
     * Runs the widget.
     */
    public function run()
    {
        $view = $this->getView();
        $gridId = $this->options['id'];
        $filterSelector = "#$gridId input, #$gridId select";
        if (isset($this->filterSelector)) {
            $filterSelector .= ', ' . $this->filterSelector;
        }
        $registerJs =
            '$("body").on("beforeFilter","#'.$gridId.'",function(e){'.
            '$.each($("'.$filterSelector.'"),function(){'.
            'var v=$(this).val();if(v=="undefined"||v==""){$(this).removeAttr("name");'.
            '}});'.
            'return true;'.
            '});';

        if (\Yii::$app->request->isPjax) {
            $registerJs .= '$(\'[data-toggle="tooltip"]\').tooltip();';
        }
        $view->registerJs($registerJs);
        BootstrapPluginAsset::register($view);

        parent::run();
    }
}
