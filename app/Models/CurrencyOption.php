<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrencyOption extends Model
{

    protected $table = 'currency_option';
    protected $primaryKey = 'id';
    protected $allowedFields = ['currency_id', 'name', 'slug', 'isDeleted', 'createdAt', 'updatedAt'];

    public function getdata()
    {
        return $this->where('isDeleted',0)->orderby('id', 'asc')->findAll();
    }
    public function getById($id)
    {
        return $this->where('id', $id)->where('isDeleted',0)->first();
    }
    public function getByCurrencyId($currencyId)
    {
        return $this->where('currency_id', $currencyId)
        ->where('isDeleted',0)
        ->findAll();
    }
    
}