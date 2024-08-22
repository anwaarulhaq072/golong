<?php

namespace App\Models;

use CodeIgniter\Model;

class Report extends Model
{

    protected $table = 'report';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userid', 'balance', 'type', 'trasition', 'widthra', 'deposit','payout','date'];

    public function getData(){
        $query = $this->orderby('date', "ASC")->findAll();
        return $query;
    }
    public function get_sum_of_diposit($id){
        $this->selectSum('deposit');
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['deposit'];
    }
    public function get_sum_of_profit($id){
        $this->selectSum('trasition');
        $this->where('userid', $id);
        $this->where('type', 'Profit');
        $query = $this->findAll();
        return $query[0]['trasition'];;
    }
    public function get_sum_of_Loss($id){
        $this->selectSum('trasition');
        $this->where('userid', $id);
        $this->where('type', 'Loss');
        $query = $this->findAll();
        return $query[0]['trasition'];;
    }
    public function get_sum_of_withdraw($id){
        $this->selectSum('widthra');
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['widthra'];;
    }
    public function get_sum_of_payout($id){
        $this->selectSum('payout');
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['payout'];;
    }
    public function deleteData($id){
        $this->truncate('report');
    }

}