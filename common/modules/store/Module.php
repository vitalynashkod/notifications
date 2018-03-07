<?php

namespace common\modules\store;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @param int $userId
     * @param string $message
     */
    public function addMessage(int $userId, string $message)
    {
        Yii::$app->redis->set('USR_' . $userId, $message);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getMessage(int $userId)
    {
        return Yii::$app->redis->get('USR_' . $userId);
    }

    /**
     * @param int $userId
     */
    public function removeMessage(int $userId)
    {
        Yii::$app->redis->del('USR_' . $userId);
    }
}