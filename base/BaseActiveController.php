<?php

namespace app\base;

use Yii;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseActiveController extends ActiveController
{

    public function behaviors(){
        $behaviors = parent::behaviors();
        return $behaviors;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->getIdentity()->isNewRecord)
        {
            throw new ForbiddenHttpException('You are not allowed to perform this operation');
        }
    }

    public function beforeAction($action)
    {
        $value = parent::beforeAction($action);
        $this->checkAccess($this->action->id);
        return $value;
    }

}
