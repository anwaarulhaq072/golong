<?php
namespace App\Models;

use CodeIgniter\Model;

class UserType extends Model{
    protected $table = 'usertype' ;
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'isDeleted', 'createdAt'];

}