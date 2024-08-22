<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttempt extends Model
{

    protected $table = 'login_attempt';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userid', 'ip', 'status','date_time'];
    // protected $allowedFields = ['userid', 'ip', 'status','date_time', 'publishDate', 'createdAt'];
    
}
