<?php

namespace App\Models;

use CodeIgniter\Model;

class Withdraw extends Model
{

    protected $table = 'withdraw';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'user_id', 'currency_id', 'currency_option_id', 'request_date', 'status', 'paid_date', 'wallet_address', 'amount', 'account_name', 'account_no', 'routing_no', 'reject_reason', 'message', 'isDeleted', 'updatedAt', 'createdAt' ];

    public function getdata()
    {
        return $this->orderby('id', 'asc')->findAll();
    }
    public function getWithdrawalsByid($id){
        $this->select('user_id');
        $this->where('id =', $id);
        $query = $this->find();
        return $query;
    }
    public function getAllWithdrawals(){
         $this->select('withdraw.id, withdraw.request_date, withdraw.status, withdraw.paid_date, withdraw.reject_reason, withdraw.message, withdraw.wallet_address, withdraw.account_name, withdraw.account_no, withdraw.routing_no,
          withdraw.amount, C.name AS currency, CO.name AS currency_option, U.firstName, U.lastName, U.profile_img');
         $this->join('currency AS C', 'C.id = withdraw.currency_id', 'LEFT');
         $this->join('currency_option AS CO', 'CO.id = withdraw.currency_option_id', 'LEFT');
        $this->join('users AS U', 'U.id = withdraw.user_id', 'LEFT');
        $this->orderby('withdraw.id', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getAllWithdrawalsByUserId($id){
        $this->select('withdraw.request_date, withdraw.status, withdraw.paid_date, withdraw.reject_reason, withdraw.message, withdraw.wallet_address, withdraw.account_name, withdraw.account_no, withdraw.routing_no, withdraw.amount, C.name AS currency, CO.name AS currency_option');
        $this->join('currency AS C', 'C.id = withdraw.currency_id', 'LEFT');
        $this->join('currency_option AS CO', 'CO.id = withdraw.currency_option_id', 'LEFT');
        $this->where('user_id =', $id);
        $this->orderby('withdraw.id', 'desc');
        $query = $this->findAll();
        return $query;
    }

    public function getAllPendingByUserId($id){
        $this->selectSum('amount');
        $this->where("(status='Pending' OR status='Accepted')");
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedByUserId($id){
        $this->selectSum('amount');
        $this->where("(status='Completed')");
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedByUserId_Overview($id){
        $this->selectSum('amount');
        $this->where("(status='Completed')");
        $this->where('user_id', $id);
        $this->like('paid_date' , '2022') ;
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedWithdrawalsByUserId($id){
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $id);
        $query = $this->findAll();
        return $query;
    }
    public function getCompletedWithdrawalsByUserId_Overview($id){
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $id);
        $this->like('paid_date' , '2022') ;
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_current_month($userid,$date)
    {
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $userid);
        $this->like('paid_date' , $date) ;
        $this->orderby('paid_date', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_months($userid,$cdate,$date)
    {
        $this->select('*');
        $this->where('status', "Completed");
        $this->where('user_id', $userid);
        $this->where('paid_date >=', $date);
        $this->where('paid_date <=', $cdate);
        $this->orderby('paid_date', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getAllPendingByUserId_month($id,$date){
        $this->selectSum('amount');
        $this->where("(status='Pending' OR status='Accepted')");
        $this->where('user_id', $id);
        $this->where('paid_date >=', $date);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getAllPendingByUserId_monthrange($id,$date,$cdate){
        $this->selectSum('amount');
        $this->where("(status='Pending' OR status='Accepted')");
        $this->where('user_id', $id);
        $this->where('paid_date >=', $date);
        $this->where('paid_date <=', $cdate);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedByUserId_month($id,$date,$ddate){
        $this->selectSum('amount');
        $this->where("(status='Completed')");
        $this->where('user_id', $id);
        // $this->like('paid_date', $date);
        $this->where('paid_date <=', $ddate);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getCompletedByUserId_range($id,$date,$cdate,$ddate){
        $this->selectSum('amount');
        $this->where("(status='Completed')");
        $this->where('user_id', $id);
        $this->where('paid_date', $ddate);
        $this->where('paid_date >=', $date);
        $this->where('paid_date <=', $cdate);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
}