<?php

namespace common\components;

use Yii;

class PhpManager extends \yii\rbac\PhpManager
{

    /**
     * @inheritdoc
     */
    public $itemFile = '@common/config/items.php';

    /**
     * @inheritdoc
     */
    public $assignmentFile = '@common/config/assignments.php';

    /**
     * @inheritdoc
     */
    public $ruleFile = '@common/config/rules.php';


    public function init()
    {
        parent::init();

        // Update assignments if empty

        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;
            $id = Yii::$app->user->identity->id;
            if (!empty($role) && !empty($id)) {
                $itemRole = $this->getRole($role);

                if ($this->getAssignment($role, $id) === null) {
                    $this->assign($itemRole, $id);
                }
            } else {
                Yii::$app->user->logout();
            }
        }
    }

    /**
     * Void. Assignments saved in user table
     */
    protected function saveAssignments()
    {
    }
}
