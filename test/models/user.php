<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    var $userid         = '';
    var $username       = '';
    var $password       = '';
    var $nama           = '';
    var $alamat         = '';
    var $telepon        = '';
    var $email          = '';
    var $status         = '';
    var $created_at     = '';
    var $updated_at     = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getUsers(){
        $this->db->select('userid,username,nama,alamat,telepon,email,status,created_at,updated_at');
        $this->db->from('user');
        $query=$this->db->get();
        return $query->result();
    }

    function getUser($id){
        $this->db->select('userid,username,nama,alamat,telepon,email,status,created_at,updated_at');
        $this->db->from('user');
        $this->db->where('userid',$id);
        $query=$this->db->get();
        return $query->result();
        }

    function getUserSyncCreated($created_at){
        $this->db->select('userid,username,nama,alamat,telepon,email,status,created_at,updated_at');
        $this->db->from('user');
        $this->db->where('created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }

    function getUserSyncUpdated($updated_at){
        $this->db->select('userid,username,nama,alamat,telepon,email,status,created_at,updated_at');
        $this->db->from('user');
        $this->db->where('updated_at >',$updated_at);
        $query=$this->db->get();
        return $query->result();
    }
    
    function getUserByUsername($username){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username =',$username);
        $query=$this->db->get();
        return $query->result();
    }

    function insertUser($username,$password,$nama,$alamat,$telepon,$email,$status){
        $newObject=new User;
        $newObject->userid=NULL;
        $newObject->username=$username;
        $newObject->password=md5($password);
        $newObject->alamat=$alamat;
        $newObject->telepon=$telepon;
        $newObject->email=$email;
        $newObject->status=$status;
        $newObject->created_at=NULL;
        $newObject->updated_at=NULL;
        if($this->db->insert('user',$newObject))
            return true;
        else 
            return false;
    }


    function updateUser($nama,$alamat,$telepon,$email,$userid){
        $data= array('nama' => $nama,
                     'alamat' => $alamat,
                     'telepon' =>$telepon,
                     'email' =>$email
                    );
        $this->db->where('userid',$userid);
        if($this->db->update('user',$data))
            return true;
        else
            return false;
    }

    function updateUserStatus($status,$userid){
        $data= array('status' => $status);
        $this->db->where('userid',$userid);
        if($this->db->update('user',$data))
            return true;
        else
            return false;
    }



}