<?php

namespace app\rbac;

use app\models\Employees;
use yii\rbac\Item;
use yii\rbac\Rule;

class ApprovalVacationRule extends Rule
{
    public $name = 'approvalVacationRule';

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (!isset($params['vacationModel'])) {
            return true;
        }

        $vacationModel = $params['vacationModel'];
        if (Employees::findOne($vacationModel->employee_id)->boss_clock_number == \Yii::$app->user->id) {
            return true;
        }

        return false;
    }
}