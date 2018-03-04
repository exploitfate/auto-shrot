<?php

namespace common\widgets;

use common\assets\toastr\ToastrAsset;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * Note: AJAX not supported. With Pjax call widget in pjax container.
 *
 * - \Yii::$app->getSession()->setFlash(ToastrAlert::ERROR, 'This is the message');
 * - \Yii::$app->getSession()->setFlash(ToastrAlert::SUCCESS, 'This is the message');
 * - \Yii::$app->getSession()->setFlash(ToastrAlert::INFO, 'This is the message');
 */
class ToastrAlert extends Widget
{
    /**
     * Delimiter for separate title and message
     *
     * @var string
     */
    public $delimiter = '||';

    /**
     * Alert types constants
     */
    const ERROR = 'error';
    const DANGER = 'error';
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';

    /**
     * toastr.options See @link http://codeseven.github.io/toastr/demo.html
     * @var array
     */
    public $clientOptions;

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    private $alertTypes = [
        self::ERROR => self::ERROR,
        self::ERROR => self::ERROR,
        self::SUCCESS => self::SUCCESS,
        self::INFO => self::INFO,
        self::WARNING => self::WARNING,
    ];

    /**
     * @var string
     */
    private $script;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        if (!isset($this->clientOptions['closeButton'])) {
            $this->clientOptions['closeButton'] = true;
        }
        if (!isset($this->clientOptions['extendedTimeOut'])) {
            $this->clientOptions['extendedTimeOut'] = 5000;
        }
        if (!isset($this->clientOptions['timeOut'])) {
            $this->clientOptions['timeOut'] = 10000;
        }
        if (!isset($this->clientOptions['progressBar'])) {
            $this->clientOptions['progressBar'] = true;
        }

        $script = '';
        foreach ($flashes as $type => $message) {
            if (isset($this->alertTypes[$type])) {
                if (strpos($message, $this->delimiter)) {
                    list($title, $message) = explode($this->delimiter, $message);
                    $script .= 'toastr.'.$type.'("'.$message.'", "'.$title.'");';
                } else {
                    $script .= 'toastr.'.$type.'("'.$message.'");';
                }
                //$session->removeFlash($type);
            }
        }
        $this->script = $script;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $view = $this->getView();
        ToastrAsset::register($view);
        $view->registerJs('toastr.options = '.Json::encode($this->clientOptions).';'.$this->script, View::POS_END);
    }
}
