<?php

namespace App\Models;

use CodeIgniter\Model;

class Payout extends Model
{

    protected $table = 'payout_send';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'amount', 'payoutdate', 'created_At'];

    public function getdata()
    {
        return $this->orderby('id')->findAll();
    }
    public function getByUserIdAndDate($id, $start_date)
    {
        $start_date = date('Y-m-d H:i:s', strtotime(date($start_date) . '00:00:00'));
        $end_date =  date('Y-m-d H:i:s', strtotime(date($start_date) . '23:59:59'));
        $this->where('user_id', $id);
        $this->where('payoutdate >=', $start_date);
        $this->where('payoutdate <=', $end_date);
        $query = $this->first();
        return $query;
    }
    public function getsum($id)
    {
        $this->where('user_id', $id);
        $this->selectSum('amount');
        $query = $this->findAll();
        return $query;
    }
    public function getsum_Overview($id)
    {
        $this->where('user_id', $id);
        $this->like('payoutdate' , '2022') ;
        $this->selectSum('amount');
        $query = $this->findAll();
        return $query;
    }
    public function getrow($id)
    {
        return $this->where('user_id', $id)->findAll();
    }
    public function getrow_Overview($id)
    {
        return $this->where('user_id', $id)->like('payoutdate' , '2022')->findAll();
    }
    public function getPayoutsdesc($id)
    {
        $this->where('user_id', $id);
        $this->orderby('payoutdate', 'desc');
        $query = $this->first();
        return $query;
    }
    public function getPayoutforviewAll($id)
    {
        $this->where('user_id', $id);
        $this->orderby('payoutdate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getPayoutsasc($id)
    {
        $this->where('user_id', $id);
        $this->orderby('payoutdate', 'asc');
        $query = $this->first();
        return $query;
    }
    public function getBydate($date)
    {
        $this->where('payoutdate', $date);
        $query = $this->first();
        return $query;
    }
    // public function getCurrentDataNotifications()
    // {
    //     // $start_date = date('Y-m-d h:i:s');
    //     $start_date = date('Y-m-d H:i:s', time());
    //     $this->where('status', "Enable");
    //     $this->where('publishDate <=', $start_date);
    //     $this->orderby('publishDate', "desc");
    //     $query = $this->findAll();
    //     return $query;
    // }

    public function get_last_data_id()
    {
        return $this->orderby('id', 'desc')->first();
    }
    public function getByUserId_current_month($userid,$date)
    {
        $this->select('*');
        $this->where('user_id', $userid);
        $this->like('payoutdate' , $date) ;
        $this->orderby('payoutdate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_months($userid,$cdate,$date)
    {
        $this->select('*');
        $this->where('user_id', $userid);
        $this->where('payoutdate >=', $date);
        $this->where('payoutdate <=', $cdate);
        $this->orderby('payoutdate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getsum_month($id,$date)
    {
        $this->where('user_id', $id);
        $this->selectSum('amount');
        $this->where('payoutdate <=' ,$date);
        $query = $this->findAll();
        return $query;
    }
    
    public function getsum_monthrange($id,$date,$cdate)
    {
        $this->where('user_id', $id);
        $this->selectSum('amount');
        $this->where('payoutdate >=', $date);
        $this->where('payoutdate <=', $cdate);
        $query = $this->findAll();
        return $query;
    }
}
