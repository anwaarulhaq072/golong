<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertStatus extends Model
{

    protected $table = 'alert_status';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'alerts_id', 'is_read', 'createdAt', 'isDeleted'];


    public function getCurrentAlertNotificationById($id){
        $start_date = date('Y-m-d H:i:s', time());
        $this->select('alert_status.id, N.title, N.description,N.publishDate, alert_status.user_id,alert_status.is_read');
        $this->join('alerts AS N', 'N.id = alert_status.alerts_id', 'LEFT');
        $this->where('alert_status.user_id =', $id);
        // $this->where('N.status', "Enable");
        // $this->where('N.publishDate <=', $start_date);
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentAlertNotificationsByIdCount($id)
    {
        $this->select('alert_status.id');
        $this->join('alerts AS N', 'N.id = alert_status.alerts_id', 'LEFT');
        $this->where('alert_status.user_id =', $id);
        $this->where('alert_status.is_read', "N");
        $this->orderby('N.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentDataAlertsByUserId($id)
    {
        $start_date = date('Y-m-d H:i:s', time());
        $this->select('alert_status.id, A.title, A.description,A.publishDate, alert_status.user_id,alert_status.is_read');
        $this->join('alerts AS A', 'A.id = alert_status.id', 'LEFT');
        $this->where('alert_status.user_id =', $id);
        // $this->where('N.status', "Enable");
        // $this->where('N.publishDate <=', $start_date);
        $this->orderby('A.id', "desc");
        $query = $this->findAll();
        return $query;
    }
    
}