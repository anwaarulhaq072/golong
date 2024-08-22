<?php

namespace App\Models;

use CodeIgniter\Model;

class Singlenotification extends Model
{

    protected $table = 'user_notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'notification_id', 'is_read', 'createdAt', 'isDeleted'];

    public function getdata()
    {
        return $this->orderby('id')->findAll();
    }
    public function getrow($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getCurrentDataNotificationsByUserId($id)
    {
        $start_date = date('Y-m-d H:i:s', time());
        $this->select('user_notifications.id, N.title, N.description,N.publishDate, user_notifications.user_id,user_notifications.is_read');
        $this->join('notifications AS N', 'N.id = user_notifications.notification_id', 'LEFT');
        $this->where('user_notifications.user_id =', $id);
        $this->where('N.status', "Enable");
        // $this->where('N.publishDate <=', $start_date);
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentDataNotificationsByUserIdCount($id)
    {
        $this->select('user_notifications.id');
        $this->join('notifications AS N', 'N.id = user_notifications.notification_id', 'LEFT');
        $this->where('user_notifications.user_id =', $id);
        $this->where('N.status', "Enable");
        $this->where('user_notifications.is_read', "N");
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentDataNotificationsByNotificationId($id)
    {
        $this->select('user_notifications.id, N.title, N.description,N.publishDate, user_notifications.user_id,user_notifications.is_read');
        $this->join('notifications AS N', 'N.id = user_notifications.notification_id', 'LEFT');
        $this->where('user_notifications.notification_id =', $id);
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentDataNotificationsByUserIdCronJob()
    {
        $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $end_time = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '23:59:59'));
        $this->select('user_notifications.id,user_notifications.notification_id, N.title, N.description,N.publishDate, user_notifications.user_id,user_notifications.is_read, U.email');
        $this->join('notifications AS N', 'N.id = user_notifications.notification_id', 'LEFT');
        $this->join('users AS U', 'U.id = user_notifications.user_id', 'LEFT');
        $this->where('N.status', "Enable");
        $this->where("publishDate >= '$start_date' AND publishDate <= '$end_time'");
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
}
