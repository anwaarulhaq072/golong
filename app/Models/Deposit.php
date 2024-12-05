<?php

namespace App\Models;

use CodeIgniter\Model;

class Deposit extends Model
{

    protected $table = 'deposit';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'user_id', 'currency_id', 'currency_option_id', 'amount', 'deposite_date', 'status', 'accepted_date', 'reject_reason', 'message', 'isDeleted', 'updatedAt', 'createdAt'];

    public function getdata()
    {
        return $this->orderby('id', 'desc')->findAll();
    }

    public function getAllDeposits(){
        $this->select('deposit.id, deposit.deposite_date, deposit.status, deposit.accepted_date,
         deposit.reject_reason, deposit.message, deposit.amount, C.name AS currency, CO.name AS currency_option, 
         U.firstName, U.lastName, U.profile_img');
        $this->join('currency AS C', 'C.id = deposit.currency_id', 'LEFT');
        $this->join('currency_option AS CO', 'CO.id = deposit.currency_option_id', 'LEFT');
        $this->join('users AS U', 'U.id = deposit.user_id', 'LEFT');
        $this->orderby('deposit.id', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getDepositsbyid($id){
        $this->select('*');
        $this->where('id =', $id);
        $query = $this->find();
        return $query;
    }

    public function getAllDepositsByUserId($id){
        $this->select('deposit.deposite_date, deposit.status, deposit.accepted_date, deposit.message, deposit.reject_reason, deposit.amount, C.name AS currency, CO.name AS currency_option');
        $this->join('currency AS C', 'C.id = deposit.currency_id', 'LEFT');
        $this->join('currency_option AS CO', 'CO.id = deposit.currency_option_id', 'LEFT');
        $this->where('user_id =', $id);
        $this->orderby('deposit.id', 'desc');
        $query = $this->findAll();
        return $query;
    }

    public function getAcceptedDepositByUserId($id){
        $this->selectSum('amount');
        $this->where('status', "Completed");
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedDepositByUserId($id){
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query;
    }
    public function getCompletedDepositByUserId_Overview($id){
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $id);
        $this->like('deposite_date' , '2022');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_current_month($userid,$date)
    {
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $userid);
        $this->like('accepted_date' , $date) ;
        $this->orderby('accepted_date', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_months($userid,$cdate,$date)
    {
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $userid);
        $this->where('accepted_date >=', $date);
        $this->where('accepted_date <=', $cdate);
        $this->orderby('accepted_date', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getAcceptedDepositByUserId_month($id,$date,$wdate){
        $this->selectSum('amount');
        $this->where('status', "Completed");
        $this->like('accepted_date' , $date) ;
        $this->where('accepted_date <=', $wdate);
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getAcceptedDepositByUserId_range($id,$date,$cdate,$wdate){
        $this->selectSum('amount');
        $this->where('status', "Completed");
        $this->where('accepted_date <=', $wdate);
        $this->where('accepted_date >=', $date);
        $this->where('accepted_date <=', $cdate);
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }

}