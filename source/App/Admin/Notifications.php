<?php

namespace Source\App\Admin;

use Source\Models\Notification;

class Notifications extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function count(): void
    {
        $json["count"] = (new Notification())->find("view < 1")->count();
        echo json_encode($json);
    }

    public function list()
    {
        $notifications = (new Notification())->order("view ASC, created_at DESC")->limit(10)->find()->fetch(true);

        if (!$notifications) {
            $json["message"] = $this->message->info("No momento não existem notificações por aqui")->render();
            echo json_encode($json);
            return;
        }
        $notificationsList = null;
        foreach ($notifications as $notification) {
            $notification->view = 1;
            $notification->save();
            $notification->created_at = date_fmt($notification->created_at);
            $notificationsList[] = $notification->data();
        }
        echo json_encode(["notifications" => $notificationsList]);
    }
}
