<?php

namespace common\widgets;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class ActionColumn
 * @package common\widgets
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Replace hardcoded `id` by primaryKey references
     * @inheritdoc
     */
    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        } else {
            /** @var ActiveRecord $model */
            $static = $model::primaryKey();
            $primaryKey = reset($static);

            $params = is_array($key) ? $key : [$primaryKey => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }
}
