<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Model {

    var $categoryid     = '';
    var $categoryname   = '';
    var $created_at     = '';
    var $updated_at     = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     function getCategories(){
        $this->db->select('*');
        $this->db->from('category');
        $query=$this->db->get();
        return $query->result();
    }

    function getCategoriesSyncCreated($created_at){
       	$this->db->select('*');
       	$this->db->from('category');
        $this->db->where('created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }

    function getCategoriesSyncUpdated($updated_at){
       	$this->db->select('*');
        $this->db->from('category');
        $this->db->where('updated_at >',$updated_at);
        $query=$this->db->get();
        return $query->result();
    }

    function insertCategory($categoryname){
        $newObject=new Category;
        $newObject->categoryid=NULL;
        $newObject->categoryname=$username;
        $newObject->created_at=NULL;
        $newObject->updated_at=NULL;
        if($this->db->insert('category',$newObject))
            return true;
        else 
            return false;
    }

	function updateCategory($categoryname,$categoryid){
        $data= array('categoryname' => $categoryname
                    );
        $this->db->where('categoryid',$categoryid);
        if($this->db->update('category',$data))
            return true;
        else
            return false;
    }


}