<?php

namespace common\models;

use yii\base\Model;
use yii\grid\DataColumn as BaseDataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DataColumn
 * @package common\models
 */
class DataColumn extends BaseDataColumn
{
    public $filterPretty = true;

    /**
     * Tooltip content
     *
     * @var string
     */
    public $tooltip;

    /**
     * Tooltip options. See @link http://getbootstrap.com/javascript/#tooltips
     *
     * @var array
     */
    public $tooltipOptions = [
        'class' => 'tooltips tooltip-icon glyphicon glyphicon-info-sign',
        'tag' => 'span',
        'html' => true,
    ];

    protected $tooltipAttributes = [
        'animation',
        'container',
        'delay',
        'html',
        'placement',
        'selector',
        'template',
        'title',
        'trigger',
        'viewport',
    ];

    /**
     * @inheritdoc
     */
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null || $this->label === null && $this->attribute === null) {
            return parent::renderHeaderCellContent();
        }

        $label = $this->getHeaderCellLabel();
        if ($this->encodeLabel) {
            $label = Html::encode($label);
        }

        $content = $label;
        $tooltip = $this->getTooltip();
        if ($this->attribute !== null && $this->enableSorting &&
            ($sort = $this->grid->dataProvider->getSort()) !== false && $sort->hasAttribute($this->attribute)) {
            $content = $sort->link($this->attribute, array_merge($this->sortLinkOptions, ['label' => $label]));
        }

        return $content.$tooltip;
    }


    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false &&
            $model instanceof Model &&
            $this->attribute !== null &&
            $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            $this->filterInputOptionsNormalize();
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            } else {
                return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }

    /**
     * Update filter input options. Setup pretty input name when enabled
     */
    protected function filterInputOptionsNormalize()
    {
        if ((bool)$this->filterPretty === true) {
            if (!array_key_exists('name', $this->filterInputOptions)) {
                $this->filterInputOptions['name'] = $this->attribute;
            }
        }
    }

    /**
     * Get tooltip content. Make sure bootstrap plugin registered.
     * @return string
     */
    protected function getTooltip()
    {
        if (!empty($this->tooltip)) {
            $options = $this->tooltipOptions;
            $tag = ArrayHelper::remove($options, 'tag');
            foreach ($this->tooltipAttributes as $attribute) {
                if (array_key_exists($attribute, $options)) {
                    $optionsData[$attribute] = ArrayHelper::remove($options, $attribute);
                }
            }
            $optionsData['toggle'] = 'tooltip';
            $options['title'] = $this->tooltip;
            $options['data'] = $optionsData;
            return ' '.Html::tag($tag, '', $options);
        }

        return '';
    }
}
