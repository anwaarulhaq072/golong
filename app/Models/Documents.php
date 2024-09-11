<?php
namespace App\Models;

use CodeIgniter\Model;

class Documents extends Model{

    protected $table = 'documents' ;
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','link','filename','createdAt', 'isDeleted'];

    public function getdata($id)
    {
        // return $this->where('user_id' , $id)->orderby('id', 'desc')->findAll();
        return $this->select('U.firstName,U.lastName,documents.*')->join('users AS U', 'U.id = documents.user_id', 'LEFT')->where('user_id' , $id)->orderby('documents.id', 'desc')->findAll();

    }
     public function getdata_all()
    {
        return $this->select('U.firstName,U.lastName,documents.*')->join('users AS U', 'U.id = documents.user_id', 'LEFT')->orderby('documents.id', 'desc')->findAll();
    }

}

?>