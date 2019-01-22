<?php

namespace app\controllers;

use app\models\Employees;
use app\models\Vacations;
use app\rbac\ApprovalVacationRule;
use app\rbac\UpdateVacationRule;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class VacationController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create-vacation', 'read-vacation', 'update-vacation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['approval-vacations', 'approval-vacation'],
                        'allow' => true,
                        'roles' => ['boss'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Действие по занесению отпусков.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreateVacation()
    {
        $vacationModel = new Vacations();

        // Если форма не отправлена.
        if (!$vacationModel->load(\Yii::$app->request->post())) {
            return $this->render('create-vacation', [
                'vacationModel' => $vacationModel
            ]);
        }

        // Закрепляем отпуск за сотрудником, форматируем данные.
        $vacationModel->employee_id = \Yii::$app->user->getId();
        $vacationModel->date_end = date('Y-m-d', strtotime($vacationModel->date_end));
        $vacationModel->date_start = date('Y-m-d', strtotime($vacationModel->date_start));

        // Занесение данных в бд.
        if (!$vacationModel->save()) {
            \Yii::$app->session->addFlash('danger', 'Произошла ошибка.');
            return $this->render('create-vacation', [
                'vacationModel' => $vacationModel
            ]);
        }

        \Yii::$app->session->addFlash('success', 'Отпуск успешно внесен.');
        return $this->refresh();
    }

    /**
     * Просмотр отпусков.
     *
     * @return string
     */
    public function actionReadVacation()
    {
        $vacations = Vacations::find()->all();

        return $this->render('read-vacation', [
            'vacations' => $vacations
        ]);
    }

    /**
     * Действие по редактированию отпуска.
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateVacation($id)
    {
        $vacationModel = Vacations::findOne($id);

        // Существует ли отпуск.
        if (empty($vacationModel)) {
            throw new NotFoundHttpException('Отпуск не найден', 404);
        }

        // Правило на разрешении.
        if (
            !\Yii::$app->user->can('updateVacation', ['vacationModel' => $vacationModel])
            || !$vacationModel->isUpdatable()
        ) {
            throw new ForbiddenHttpException('Так делать не стоит', 403);
        }

        // Если форма не пришла.
        if (!$vacationModel->load(\Yii::$app->request->post())) {
            $vacationModel->date_start = date('d-m-Y', strtotime($vacationModel->date_start));
            $vacationModel->date_end = date('d-m-Y', strtotime($vacationModel->date_end));
            return $this->render('update-vacation', [
                'vacationModel' => $vacationModel
            ]);
        }

        $vacationModel->date_end = date('Y-m-d', strtotime($vacationModel->date_end));
        $vacationModel->date_start = date('Y-m-d', strtotime($vacationModel->date_start));

        // Занесение данных в бд.
        if (!$vacationModel->save()) {
            \Yii::$app->session->addFlash('danger', 'Произошла ошибка.');
            return $this->render('create-vacation', [
                'vacationModel' => $vacationModel
            ]);
        }

        \Yii::$app->session->addFlash('success', 'Отпуск успешно изменен.');
        return $this->refresh();
    }

    /**
     * Действие просмотра отпусков своих подчиненных
     * с возможным последующим согласованием.
     *
     * @return string
     */
    public function actionApprovalVacations()
    {
        $employeesID = [];
        $employeesModels = Employees::getEmployeesUnderBoss(\Yii::$app->user->id);
        foreach ($employeesModels as $employee) {
            $employeesID[] = $employee->clock_number;
        }

        $vacations = Vacations::find()
            ->where(['in', 'employee_id', $employeesID])
            ->all();

        return $this->render('approval-vacations', [
            'vacations' => $vacations
        ]);
    }

    /**
     * Согласование отпуска.
     *
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionApprovalVacation($id)
    {
        $vacationModel = Vacations::findOne($id);

        // Существует ли отпуск.
        if (empty($vacationModel)) {
            throw new NotFoundHttpException('Отпуск не найден', 404);
        }

        // Правило на разрешении.
        if (!\Yii::$app->user->can('approvalVacation', ['vacationModel' => $vacationModel])) {
            throw new ForbiddenHttpException('Так делать не стоит', 403);
        }

        $vacationModel->status = Vacations::APPROVAL_VACATION;

        // Занесение данных в бд.
        if (!$vacationModel->save()) {
            \Yii::$app->session->addFlash('danger', 'Произошла ошибка.' . $str);
        } else {
            \Yii::$app->session->addFlash('success', 'Отпуск успешно согласован.');
        }

        return $this->redirect(['vacation/approval-vacations']);
    }
}
