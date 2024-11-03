<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationsModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'type', 'message', 'created_at', 'read_at'];

    protected $useTimestamps = false;

    public function getUnreadNotifications($userId)
    {
        return $this->where('user_id', $userId)
            ->whereNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function createNotification($data)
    {
        return $this->insert($data);
    }

    public function markAsRead($notificationId)
    {
        return $this->set(['read_at' => date('Y-m-d H:i:s')])
            ->where('id', $notificationId)
            ->update();
    }
}
