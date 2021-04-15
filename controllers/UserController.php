<?php
namespace app\controllers;
use yii\filters\auth\HttpBearerAuth;

use yii\rest\ActiveController;

class UserController extends ActiveController
{

    public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => HttpBearerAuth::className(),
    ];
    return $behaviors;
}

    public $modelClass = 'app\models\User';
}