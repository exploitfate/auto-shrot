<?php

namespace common\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Request;

/**
 * LinkPager with pageSize selector
 *
 * For activate page size need set \yii\data\Pagination::pageSizeLimit in config like this
 *
 * \Yii::$container->set(\yii\data\Pagination::class, [
 *     'pageSizeLimit' => [1, 1000],
 * ]);
 *
 */
class LinkPager extends Widget
{
    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make LinkPager work.
     */
    public $pagination;

    /**
     * @var array Page size available value
     */
    public $sizes = [
        10 => '10',
        20 => '20',
        50 => '50',
        100 => '100',
        200 => '200',
        500 => '500',
        1000 => '1000',
    ];

    /**
     * @var bool Add pagination meta link
     */
    public $registerLinkTags = true;

    /**
     * @var bool Show page size selector
     */
    public $showPageSize = true;

    /**
     * @var bool Wrap drop down in form container
     */
    public $useForm = true;

    /**
     * @var bool Flip drop down container to left
     */
    public $flip = false;

    /**
     * @var array LinkPager (pagination) HTML options
     */
    public $linkPagerOptions;

    /**
     * @var array DropDown HTML options
     */
    public $dropDownOptions;

    /**
     * @var array DropDown page size container HTML options
     */
    public $pageSizeOptions;

    /**
     * @var array Pager HTML options
     */
    public $pagerOptions = ['class' => 'pagination'];

    /**
     * @inheritdoc
     */
    public $options = ['class' => 'size-link-pager'];

    /**
     * @var array Default page size value
     */
    protected $sizesDefault = [
        10 => 10,
        20 => 20,
        50 => 50,
    ];

    /**
     * @var string Default container HTML tag
     */
    protected $defaultTag = 'div';

    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];

    /**
     * @var string the CSS class for the "first" page button.
     */
    public $firstPageCssClass = 'first';

    /**
     * @var string the CSS class for the "last" page button.
     */
    public $lastPageCssClass = 'last';

    /**
     * @var string the CSS class for the "previous" page button.
     */
    public $prevPageCssClass = 'prev';

    /**
     * @var string the CSS class for the "next" page button.
     */
    public $nextPageCssClass = 'next';

    /**
     * @var string the CSS class for the active (currently selected) page button.
     */
    public $activePageCssClass = 'active';

    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = 'disabled';

    /**
     * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount = 10;

    /**
     * @var string|boolean the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '&raquo;';

    /**
     * @var string|boolean the text label for the previous page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '&laquo;';

    /**
     * @var string|boolean the text label for the "first" page button. Note that this will NOT be HTML-encoded.
     * Default is false that means the "first" page button will not be displayed.
     */
    public $firstPageLabel = false;

    /**
     * @var string|boolean the text label for the "last" page button. Note that this will NOT be HTML-encoded.
     * Default is false that means the "last" page button will not be displayed.
     */
    public $lastPageLabel = false;

    /**
     * @var boolean whether to show link the "average" page button.
     * When false that means the "average" page button will not be displayed.
     */
    public $averagePage = true;

    /**
     * @var boolean Hide widget when only one page exist.
     */
    public $hideOnSinglePage = true;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }
        if ((bool)$this->showPageSize === true) {
            Html::addCssClass($this->options, 'text-nowrap');
            if ($this->useForm) {
                if (empty($this->pageSizeOptions['class'])) {
                    Html::addCssClass($this->pageSizeOptions, 'form-inline');
                }
                if (empty($this->dropDownOptions['class'])) {
                    Html::addCssClass($this->dropDownOptions, 'form-control');
                }
                if (empty($this->dropDownOptions['onchange'])) {
                    $this->dropDownOptions['onchange'] = "this.form.submit();";
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        return $this->renderPageSize();
    }

    /**
     * Render widget
     *
     * @return string
     */
    public function renderPageSize()
    {
        $tag = $this->getTag($this->options);
        $pager = $this->renderPageButtons();
        $dropDown = $this->renderDropDownContainer();
        if ($this->flip) {
            $content = $dropDown . PHP_EOL . $pager;
        } else {
            $content = $pager . PHP_EOL . $dropDown;
        }

        return Html::tag($tag, $content, $this->options);
    }

    /**
     * Render DropDown page size container
     *
     * @return string
     */
    protected function renderDropDownContainer()
    {
        $content = PHP_EOL;
        if ($this->showPageSize === true) {
            $sizes = $this->getNormalizedSizes();
//            if (min($sizes) < $this->pagination->totalCount) {
            if ($this->useForm) {
                $content =
                    Html::beginForm($this->createUrl(), 'get', $this->pageSizeOptions) .
                    $this->renderDropDown(
                        $this->pagination->pageSizeParam,
                        $this->pagination->getPageSize(),
                        $sizes,
                        $this->dropDownOptions
                    ) .
                    Html::endForm();
            } else {
                $tag = $this->getTag($this->pageSizeOptions);
                $content =
                    Html::tag(
                        $tag,
                        $this->renderDropDown(
                            $this->pagination->pageSizeParam,
                            $this->pagination->getPageSize(),
                            $sizes,
                            $this->dropDownOptions
                        ),
                        $this->pageSizeOptions
                    );
            }
//            }
        }

        return $content;
    }

    /**
     *  Render DropDown page size selector
     *
     * @param string $pageSizeParam
     * @param string $pageSize
     * @param array $sizes
     * @param array $options
     * @return string
     */
    protected function renderDropDown($pageSizeParam, $pageSize, $sizes, $options)
    {
        return Html::dropDownList($pageSizeParam, $pageSize, $sizes, $options);
    }

    /**
     * Normalize from action route
     *
     * @return string
     */
    public function createUrl()
    {
        $request = \Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams() : [];
        $params[0] = \Yii::$app->controller->getRoute();
        if (isset($params[$this->pagination->pageSizeParam])) {
            unset($params[$this->pagination->pageSizeParam]);
        }

        return \Yii::$app->urlManager->createUrl($params);
    }

    /**
     * Filter page size array
     *
     * @return array
     */
    protected function getNormalizedSizes()
    {
        $min = min($this->pagination->pageSizeLimit);
        $max = max($this->pagination->pageSizeLimit);

        $sizes = array_flip($this->sizes);
        $sizes = array_filter(
            $sizes,
            function ($size) use ($min, $max) {
                return ($size >= $min && $size <= $max);
            }
        );
        $sizes = array_flip($sizes);
        if (empty($sizes)) {
            $sizes = $this->sizesDefault;
        }

        return $sizes;
    }

    /**
     * Get HTML tag from taken HTML options array
     *
     * @param array $options HTML options
     * @return string
     */
    protected function getTag(&$options)
    {
        $tag = ArrayHelper::remove($options, 'tag');
        if (empty($tag)) {
            $tag = $this->defaultTag;
        }

        return $tag;
    }

    /**
     * Registers relational link tags in the html header for prev, next, first and last page.
     * These links are generated using [[\yii\data\Pagination::getLinks()]].
     * @see http://www.w3.org/TR/html401/struct/links.html#h-12.1.2
     */
    protected function registerLinkTags()
    {
        $view = $this->getView();
        foreach ($this->pagination->getLinks() as $rel => $href) {
            $view->registerLinkTag(['rel' => $rel, 'href' => $href], $rel);
        }
        // + canonical link
        $view->registerLinkTag(
            [
                'rel' => 'canonical',
                'href' => \Yii::$app->urlManager->createUrl(\Yii::$app->controller->getRoute()),
            ],
            'canonical'
        );
    }


    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $buttons = [];
        $currentPage = $this->pagination->getPage();
        // first page
        if ($this->firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton(
                $this->firstPageLabel,
                0,
                $this->firstPageCssClass,
                $currentPage <= 0,
                false
            );
        }
        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton(
                $this->prevPageLabel,
                $page,
                $this->prevPageCssClass,
                $currentPage <= 0,
                false
            );
        }
        // calculate internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        // calculate left average page
        $leftAveragePage = 1;
        if ($this->averagePage !== false && $beginPage > 5) {
            $beginPage += 2;
            $leftAveragePage = floor(($beginPage + 1) / 2);
        }
        // calculate right average page
        $rightAveragePage = $pageCount;
        if ($this->averagePage !== false && $endPage + 5 < $pageCount) {
            $endPage -= 2;
            $rightAveragePage = ceil(($endPage + $pageCount) / 2);
        }
        // average page
        if ($leftAveragePage > 1 && $leftAveragePage < $beginPage) {
            if ($this->firstPageLabel === false) {
                // first page
                $buttons[] = $this->renderPageButton(1, 0, $this->firstPageCssClass, false, false);
            }
            // left average page
            $buttons[] = $this->renderPageButton($leftAveragePage + 1, $leftAveragePage, null, false, false);
        }
        // internal page
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }
        // average page
        if ($rightAveragePage > $endPage && $rightAveragePage < $pageCount) {
            // right average page
            $buttons[] = $this->renderPageButton($rightAveragePage + 1, $rightAveragePage, null, false, false);
            if ($this->lastPageLabel === false) {
                // last page
                $buttons[] = $this->renderPageButton($pageCount, $pageCount - 1, $this->lastPageCssClass, false, false);
            }
        }
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton(
                $this->nextPageLabel,
                $page,
                $this->nextPageCssClass,
                $currentPage >= $pageCount - 1,
                false
            );
        }
        // last page
        if ($this->lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton(
                $this->lastPageLabel,
                $pageCount - 1,
                $this->lastPageCssClass,
                $currentPage >= $pageCount - 1,
                false
            );
        }

        return Html::tag('ul', implode("\n", $buttons), $this->pagerOptions);
    }


    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage = $this->pagination->getPage();
        $pageCount = $this->pagination->getPageCount();

        $beginPage = max(0, $currentPage - (int)($this->maxButtonCount / 2));
        if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount) {
            $endPage = $pageCount - 1;
            $beginPage = max(0, $endPage - $this->maxButtonCount + 1);
        }

        return [$beginPage, $endPage];
    }
}
