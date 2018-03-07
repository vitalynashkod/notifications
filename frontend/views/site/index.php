<?php

/* @var $this yii\web\View */

$this->title = 'Notifications';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Notifications</h1>
    </div>

    <div class="body-content">
    </div>
</div>


<?php
    if (Yii::$app->getUser()->getId()) {
        $this->registerJs('Notification.init(' . Yii::$app->getUser()->getId() . ')', yii\web\View::POS_READY);
    }