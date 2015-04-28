<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publish extends CI_Model {

    var $publishid   = '';
    var $productid          = '';
    var $caption          = '';
    var $message         = '';
    var $created_at          = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	
	function getPublishSyncCreated($created_at){
        $this->db->select('productid as id, caption , message');
        $this->db->from('product_publish');
        $this->db->where('created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }


}