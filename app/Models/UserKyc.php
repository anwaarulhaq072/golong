<?php

namespace App\Models;

use CodeIgniter\Model;

class UserKyc extends Model
{

    protected $table = 'user_kyc';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userid', 'id_front_side', 'id_back_side','type', 'origination_docs', 'shareholder_agreement', 'proof_of_good', 'proof_of_address','status' ,'updated_at', 'created_at'];

    public function getrow($id)
    {
        return $this->where('userid', $id)->first();
    }

}