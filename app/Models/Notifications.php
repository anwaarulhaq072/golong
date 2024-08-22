<?php

namespace App\Models;

use CodeIgniter\Model;

class Notifications extends Model
{

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'status', 'publishDate', 'createdAt', 'isDeleted'];

    public function getdata()
    {
        return $this->orderby('id')->findAll();
    }
    public function getrow($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getEnableNotifications()
    {
        $this->where('status', "Enable");
        $this->orderby('id', "desc");
        $query = $this->findAll();
        return $query;
    }
    public function getCurrentDataNotifications()
    {
        // $start_date = date('Y-m-d h:i:s');
        $start_date = date('Y-m-d H:i:s', time());
        $this->where('status', "Enable");
        // $this->where('publishDate <=', $start_date);
        $this->orderby('id', "desc");
        $query = $this->findAll();
        return $query;
    }

    public function get_last_data_id()
    {
        return $this->orderby('id', 'desc')->first();
    }
}
