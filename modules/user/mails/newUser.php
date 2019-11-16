<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
$userLink = Yii::$app->urlManager->createAbsoluteUrl(['admin/users/view', 'id' => $user->id]);
?>

Зарегистрирован новый пользователь, <?= Html::encode($user->getFullName()) ?>!

Для необходимости, привяжите к нему контрагента:

<?= Html::a(Html::encode($userLink), $userLink) ?>

Это письмо сгенерировано автоматически и отвечать на него не нужно.