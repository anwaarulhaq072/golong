<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['initialInvestment', 'flagfor_accountant', 'firstName', 'lastName', 'profile_img' , 'email', 'otp', 'nextpayoutDate', 'password', 'phone','token', 'address1', 'address2', 'city', 'country', 'returntype_id', 'zip', 'userTypeId', 'uniqueCode', 'payoutDate', 'transactionType', 'notificationStatus', 'createdAt', 'updatedAt', 'isDeleted', 'payout_per', 'sessionid','bearer_token','tax_form_flag','bio'];

    public function getdata()
    {
        return $this->orderby('id', 'desc')->findAll();
    }
    public function getCustomers()
    {
        $this->orderby('id', 'desc');
        $this->where('userTypeId', 2);
        $this->where('isDeleted', 'N');
        $this->select('*');
        $query = $this->findAll();
        return $query;
    }
    public function getCustomersforaccountant()
    {
        $this->orderby('id', 'desc');
        $this->where('userTypeId', 2);
        $this->where('isDeleted', 'N');
        $this->where('flagfor_accountant', 'Y');
        $this->select('*');
        $query = $this->findAll();
        return $query;
    }
    public function getrow($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getuser_email($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserByCode($code)
    {
        return $this->where('uniqueCode', $code)->first();
    }
    public function DataforBulkUpdate($date)
    {
        $result = $this->query(" SELECT u.id, u.firstName, u.lastName, 
        max(CASE WHEN CAST(pl.publishDate AS DATE) = '$date' then pl.publishDate ELSE NULL END) AS recordDate,
        max(CASE WHEN CAST(pl.publishDate AS DATE) = '$date' then pl.`type` ELSE NULL END) AS TYPE,
        max(CASE WHEN CAST(pl.publishDate AS DATE) = '$date' then pl.amount ELSE NULL END) AS amount,
        max(CASE WHEN CAST(pl.publishDate AS DATE) = '$date' then pl.percentage ELSE NULL END) AS percentage
        FROM users AS u
        LEFT JOIN profit_loss AS pl ON u.id = pl.userid
        WHERE u.userTypeId = 2 AND u.isDeleted = 'N'
        GROUP BY u.id");
        return $result->getResultArray();
    }
    public function getAllAdminEmails(){
        $this->select('email');
        $this->where('userTypeId', 1);
        $this->where('isDeleted', 'N');
        $query = $this->findAll();
        return $query;
    }
    
    public function getAllemail()
    {
        $result = $this->query(" SELECT email
        FROM users
        WHERE userTypeId = 2 AND isDeleted = 'N'");
        return $result->getResultArray();
    }
    public function emailExist($email)
    {
        $result = $this->query(" SELECT id , email
        FROM users
        WHERE userTypeId = 2 AND isDeleted = 'N' AND email = '$email'");
        return $result->getResultArray();
    }
    public function phoneExist($phone)
    {
        $result = $this->query(" SELECT id , phone
        FROM users
        WHERE userTypeId = 2 AND isDeleted = 'N' AND phone = '$phone'");
        return $result->getResultArray();
    }
    public function getAllid()
    {
        $result = $this->query(" SELECT id
        FROM users
        WHERE userTypeId = 2 AND isDeleted = 'N'");
        return $result->getResultArray();
    }
    public function getAllAdminId(){
        $this->where('userTypeId', 1);
        $this->where('isDeleted', 'N');
        $this->select('id');
        $query = $this->findAll();
        return $query ;
    }
    public function getAllemailfornotifi($id)
    {
        $this->where('userTypeId', 2);
        $this->where('isDeleted', 'N');
        $this->where('id', $id);
        $this->select('email');
        $query = $this->findAll();
        return $query;
    }
    public function getDataForNotification()
    {
        $result = $this->query(" SELECT id , firstName , lastName 
        FROM users
        WHERE userTypeId = 2 AND isDeleted = 'N'");
        return $result->getResultArray();
    }
    // public function get_last_data_id(){
    //     return $this->orderby('id', 'desc')->first();
    // }
    public function getReturnTypeId($id)
    {
        $this->select('RN.name');
        $this->join('return_type AS RN', 'RN.id = users.returntype_id', 'LEFT');
        $this->where('users.id =', $id);
        $query = $this->findAll();
        return $query;
    }
}
