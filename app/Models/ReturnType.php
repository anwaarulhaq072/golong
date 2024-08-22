<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnType extends Model
{
    protected $table = 'return_type';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'createdAt'];
}
