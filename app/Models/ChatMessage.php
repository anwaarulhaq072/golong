<?php
namespace App\Models;

use CodeIgniter\Model;

class ChatMessage extends Model{

    protected $table = 'chat_message' ;
    protected $primaryKey = 'id';
    protected $allowedFields = ['msgFrom', 'msgTo', 'message', 'createdAt', 'isDeleted'];

    public function getdata(){
        return $this->orderby('id')->findAll();
    }
    public function getrow($id){
        return $this->where('id',$id)->first();
    }
    public function getChatByUserId($id){
        $this->select('*');
        $this->where("msgFrom='$id' OR msgTo='$id'");
        $query = $this->findAll();
        return $query;
    }
}

?>