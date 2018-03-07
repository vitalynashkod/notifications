<?php

namespace console\controllers;

use consik\yii2websocket\events\WSClientCommandEvent;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use yii\console\Controller;
use Yii;

/**
 * Class NotificationController
 * @package console\controllers
 */
class NotificationController extends Controller
{
    public function actionStart()
    {
        $server = new WebSocketServer();

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN_ERROR, function($e) use($server) {
            echo 'Error opening port ' . $server->port . '\n';
        });

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function($e) use($server) {
            echo 'Server started at port ' . $server->port;
        });

        $server->on(WebSocketServer::EVENT_CLIENT_MESSAGE, function(WSClientEvent $e) {
            $userId = $e->message;
            $notificationStore = Yii::$app->getModule('store');
            $response = $notificationStore->getMessage($userId);
            if ($response) {
                $e->client->send($response);
            }
            $notificationStore->removeMessage($userId);
        });

        $server->start();
    }

    /**
     * @param int $userId
     * @param string $title
     * @param string $text
     * @param string $type
     */
    public function actionAdd(int $userId, string $title, string $text, string $type)
    {
        $notificationStore = Yii::$app->getModule('store');
        $notificationStore->addMessage($userId, json_encode(['title' => $title, 'text' => $text, 'type' => $type]));
    }
}