<?php

namespace App\Models;

use CodeIgniter\Model;

class Alerts extends Model
{

    protected $table = 'alerts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'publishDate', 'createdAt', 'isDeleted'];

    public function get_last_alert_id(){
        return $this->orderby('id', 'desc')->first();
    }
}