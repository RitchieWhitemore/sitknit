<?php

namespace app\widgets\pagination;

use app\widgets\pagination\assets\LinkPagerAsset;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\widgets\LinkPager as BaseWidget;

/**
 * Class LinkPager
 *
 * @package app\widgets\pagination
 */
class LinkPager extends BaseWidget
{
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination__list'];

    public $linkContainerOptions = ['class' => 'pagination__item'];

    public $linkOptions = ['class' => 'link pagination__link'];

    public $activePageCssClass = 'pagination__item--active';

    /**
     * @var string
     */
    public $prevPageCssClass = 'pagination__prev';

    /**
     * @var string
     */
    public $nextPageCssClass = 'pagination__next';

    /**
     * @var string
     */
    public $prevPageLabel = 'Назад';

    /**
     * @var string
     */
    public $nextPageLabel = 'Вперед';

    /**
     * @var string
     */
    public $disabledPageCssClass = 'pagination__item--disabled';
    /**
     * @var null|\Closure
     */
    public $renderFormatter;

    /**@var string */
    public $loadMoreUrl = '';
    /** @var bool */
    public $disablePaginator = false;
    /** @var string */
    public $layout = '';
    /** @var string */
    public $layoutButton = '';
    /** @var bool */
    public $loadMoreButton = false;
    /** @var string */
    public $paginatorClass = 'dynamic-paginator';
    /** @var string */
    public $itemsClass = 'dynamic-pager-items';
    /** @var string */
    public $countClass = 'dynamic-pager-count';
    /** @var string */
    public $buttonClass = 'btn btn-prime';
    /** @var string */
    public $buttonText = 'Загрузить ещё';

    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     *
     * @param string $label the text label for the button
     * @param int $page the page number
     * @param string $class the CSS class for the page button.
     * @param bool $disabled whether this page button is disabled
     * @param bool $active whether this page button is active
     *
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        if ($this->renderFormatter instanceof \Closure) {
            $label = call_user_func($this->renderFormatter, $label);
        }
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $disabledItemOptions = $this->disabledListItemSubTagOptions;
            $tag = ArrayHelper::remove($disabledItemOptions, 'tag', 'span');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $disabledItemOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

    /**
     * @param ActiveDataProvider $dataProvider
     * @param Controller $controller
     * @param array $options
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getPageItems($dataProvider, $controller, $options = [])
    {
        $items = [];
        $models = $dataProvider->getModels();
        foreach ($models as $model) {
            $items[] = $controller->renderPartial('_item', ['model' => $model]);
        }
        $total = $dataProvider->totalCount;
        $count = $dataProvider->count;

        $options = array_merge(
            [
                'pagination' => $dataProvider->pagination,
                'disablePaginator' => false,
            ],
            $options
        );
        return [
            'result' => 'OK',
            'count' => $count,
            'total' => $total,
            'pageCount' => $dataProvider->pagination->pageCount,
            'nextPage' => Yii::$app->request->get('page', 1) + 1,
            'paginator' => LinkPager::widget($options),
            'items' => implode(PHP_EOL, $items),
        ];
    }

    /** @inheritdoc */
    public function run()
    {
        LinkPagerAsset::register($this->view);
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo \Yii::t(
            'system',
            $this->render($this->layout ?: 'linkPager/index'),
            [
                'navigator-paginator' => $this->renderPageButtons(),
                'loadMoreButton' => $this->renderLoadMoreButton(),
            ]
        );
    }

    /**
     * @return string
     */
    public function renderPageButtons()
    {
        if ($this->disablePaginator) {
            return '';
        }

        return parent::renderPageButtons();
    }

    /**
     * @return string
     */
    public function renderLoadMoreButton()
    {
        if (!$this->loadMoreButton) {
            return '';
        }
        $currentPage = $this->pagination->getPage();
        $pageCount = $this->pagination->getPageCount();
        $page = $currentPage + 2;

        if ($page > $pageCount) {
            return '';
        }

        return $this->render($this->layoutButton ?: 'linkPager/button', [
            'buttonText' => $this->buttonText,
            'dataUrl' => Url::to(
                array_merge(
                    [$this->loadMoreUrl],
                    Yii::$app->request->getQueryParams(),
                    ['page' => $page]
                )
            ),
            'itemsClass' => $this->itemsClass,
            'countClass' => $this->countClass,
            'paginatorClass' => $this->paginatorClass,
            'buttonClass' => $this->buttonClass,
        ]);

    }
}
