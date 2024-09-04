<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfitLoss extends Model
{

    protected $table = 'profit_loss';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userid', 'amount', 'type', 'publishDate', 'current_balance', 'schedule','percentage'];

    public function getdata()
    {
        return $this->orderby('id')->findAll();
    }
    public function getrow($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getByDate($userid, $date)
    {
        $start_date = date('Y-m-d H:i:s', strtotime(date($date) . '00:00:00'));
        $end_date =  date('Y-m-d H:i:s', strtotime(date($date) . '23:59:59'));
        $this->where('userid', $userid);
        $this->where('publishDate >=', $start_date);
        $this->where('publishDate <=', $end_date);
        $this->select('*');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId($userid)
    {
        $this->where('userid', $userid);
        $this->orderby('publishDate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_current_month($userid,$date)
    {
        $this->where('userid', $userid);
        $this->like('publishDate', $date);
        $this->orderby('publishDate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_months($userid,$cdate,$date)
    {
        $this->where('userid', $userid);
        $this->where('publishDate >=', $date);
        $this->where('publishDate <=', $cdate);
        $this->orderby('publishDate', 'desc');
        $query = $this->findAll();
        return $query;
    }
    public function getByUserId_Overview($userid)
    {
        $this->where('userid', $userid);
        $this->like('publishDate', '2022');
        // $this->like
        $query = $this->findAll();
        return $query;
    }
    public function getByUserIdAndDate($userid)
    {
        $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->where('userid', $userid);
        $this->where('publishDate >=', $start_date);
        $this->orderby('publishDate');
        $query = $this->findAll();
        return $query;
    }
    public function getTotalProfitById($id)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        // $this->where('publishDate <=', $start_date);
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalProfitById_Overview($id)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        // $this->where('publishDate <=', $start_date);
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $this->like('publishDate' , '2022') ;
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalLossById($id)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        // $this->where('publishDate <=', $start_date);
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalLossById_Overview($id)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        // $this->where('publishDate <=', $start_date);
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $this->like('publishDate' , '2022') ;
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getAllProfitAndLossById($id)
    {
        $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $today_night = date('Y-m-d H:i:s', time());
        $end_time = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '23:59:59'));
        $this->select('amount, type, publishDate');
        $this->orderby('publishDate', 'asc');
        $this->where('userid', $id);
        // $this->where("(publishDate <= '$start_date' OR publishDate <= '$today_night') AND publishDate <= '$end_time'");
        $query = $this->findAll();
        return $query;
    }
    public function getAllProfitAndLossById_Overview($id)
    {
        $this->select('amount, type, publishDate');
        $this->orderby('publishDate', 'asc');
        $this->like('publishDate' , '2022') ;
        $this->where('userid', $id);
        // $this->where("(publishDate <= '$start_date' OR publishDate <= '$today_night') AND publishDate <= '$end_time'");
        $query = $this->findAll();
        return $query;
    }
    public function getMaxProfitById($id)
    {
        $this->selectMax('amount');
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getMaxLossByID($id)
    {
        $this->selectMax('amount');
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getProfitsMonthlyById($id){
        $this->select('(SUM(amount/current_balance)*100) AS amount');
        $this->select('COUNT(id) AS positions');
        $this->select('YEAR(publishDate) AS year');
        $this->select('MONTH(publishDate) AS month');
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $this->groupBy( 'DATE_FORMAT(publishDate, "%Y%m")');
        $query = $this->findAll();
        return $query;
    }
    public function getLossMonthlyById($id){
        $this->select('(SUM(amount/current_balance)*100) AS amount');
        $this->select('COUNT(id) AS positions');
        $this->select('YEAR(publishDate) AS year');
        $this->select('MONTH(publishDate) AS month');
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $this->groupBy( 'DATE_FORMAT(publishDate, "%Y%m")');
        $query = $this->findAll();
        return $query;
    }
    public function getProfitsMonthlyById_year($id,$year){
        $this->select('(SUM(amount/current_balance)*100) AS amount');
        $this->select('COUNT(id) AS positions');
        $this->select('YEAR(publishDate) AS year');
        $this->select('MONTH(publishDate) AS month');
        $this->where('type', "Profit");
        $this->where('YEAR(publishDate)',$year);
        $this->where('userid', $id);
        $this->groupBy( 'DATE_FORMAT(publishDate, "%Y%m")');
        $query = $this->findAll();
        return $query;
    }
    public function getLossMonthlyById_year($id,$year){
        $this->select('(SUM(amount/current_balance)*100) AS amount');
        $this->select('COUNT(id) AS positions');
        $this->select('YEAR(publishDate) AS year');
        $this->select('MONTH(publishDate) AS month');
        $this->where('type', "Loss");
        $this->where('YEAR(publishDate)',$year);
        $this->where('userid', $id);
        $this->groupBy( 'DATE_FORMAT(publishDate, "%Y%m")');
        $query = $this->findAll();
        return $query;
    }
    public function getTotalProfitById_by_date($id,$date)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <=', $date);
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalLossById_by_date($id,$date)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <=', $date);
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalLossById_by_daterange($id,$date,$cdate)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <=', $date);
        // $this->where('publishDate <=', $cdate);
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalProfitById_by_daterange($id,$date,$cdate)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <=', $date);
        // $this->where('publishDate <=', $cdate);
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalProfitById_by_date_for_payout($id,$date)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <', $date);
        $this->where('type', "Profit");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function getTotalLossById_for_payout($id,$date)
    {
        // $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '00:00:00'));
        $this->selectSum('amount');
        $this->where('publishDate <', $date);
        $this->where('type', "Loss");
        $this->where('userid', $id);
        $query = $this->findAll();
        return $query[0]['amount'];
    }
    public function runtime_calculate_balance_for_user_dashboard($userid,$investment){
            $result = $this->query("WITH AllTransactions AS (
                SELECT 
                    p.userid,
                    p.publishDate,
                    p.amount,
                    CASE 
                        WHEN p.type = 'profit' THEN p.amount
                        WHEN p.type = 'loss' THEN -p.amount
                        ELSE 0
                    END AS transaction_amount,
                    p.type AS transaction_type,
                    'Profit/Loss' AS transaction_category
                FROM 
                    profit_loss p
                WHERE 
                    p.userid = $userid

                UNION ALL

                SELECT 
                    wd.user_id AS userid,
                    wd.paid_date AS publishDate,
                    wd.amount,
                    -wd.amount AS transaction_amount,
                    'withdrawal' AS transaction_type,
                    'Withdrawal' AS transaction_category
                FROM 
                    withdraw wd
                WHERE 
                    wd.user_id = $userid
                    AND wd.status IN ('pending', 'completed')

                UNION ALL

                SELECT 
                    de.user_id AS userid,
                    de.accepted_date AS publishDate,
                    de.amount,
                    de.amount AS transaction_amount,
                    'deposit' AS transaction_type,
                    'Deposit' AS transaction_category
                FROM 
                    deposit de
                WHERE 
                    de.user_id = $userid
                    AND de.status = 'Completed'

                UNION ALL

                SELECT 
                    po.user_id AS userid,
                    po.payoutdate AS publishDate,
                    po.amount,
                    -po.amount AS transaction_amount,
                    'payout' AS transaction_type,
                    'Payout' AS transaction_category
                FROM 
                    payout_send po
                WHERE 
                    po.user_id = $userid
            )

            , RunningBalance AS (
                SELECT 
                    at.*,
                    SUM(transaction_amount) OVER (ORDER BY publishDate ASC ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) 
                    + $investment AS current_balance
                FROM 
                    AllTransactions at
                ORDER BY 
                    at.publishDate ASC
            )

            SELECT 
                rb.publishDate,
                rb.transaction_category,
                rb.transaction_type,
                rb.amount,
                rb.current_balance
            FROM 
                RunningBalance rb
            ORDER BY 
                rb.publishDate DESC;");
                     return $result->getResultArray();
        }
    }