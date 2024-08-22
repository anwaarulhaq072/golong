<?php

namespace App\Models;

use CodeIgniter\Model;

class Currency extends Model
{

    protected $table = 'currency';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'name', 'slug', 'isDeleted', 'createdAt', 'updatedAt'];

    public function getdata()
    {
        return $this->where('isDeleted',0)->orderby('id', 'asc')->findAll();
    }
    public function getById($id)
    {
        return $this->where('id', $id)->where('isDeleted',0)->first();
    }

}