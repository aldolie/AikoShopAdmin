<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Model {

    var $transactionid   = '';
    var $userid          = '';
    var $productid          = '';
    var $price         = '';
    var $quantity          = '';
    var $status          = '';
    var $created_at      = '';
    var $updated_at      = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function getTransactionByUserId($userid){
        $this->db->select("*");
        $this->db->from("transaction_product");
        $this->db->where("userid",$userid);
        $query=$this->db->get();
        return $query->result();
    }

	
	

    public function insertTransaction($userid,$productid,$price,$quantity,$status){
        $newObject=new Transaction;
        $newObject->transactionid=NULL;
        $newObject->userid=$userid;
		$newObject->productid=$productid;
	    $newObject->price=$price;
	    $newObject->quantity=$quantity;
        $newObject->status=$status;
        $newObject->created_at=date("Y-m-d H:i:s");
        $newObject->updated_at=NULL;
        if($this->db->insert('transaction_product',$newObject))
            return $this->db->insert_id();
        else 
            return 0;
    }
	
	function getTransactionSyncCreated($created_at,$userid){
        $this->db->select('transactionid,productname,price as harga,quantity,transaction_product.status,transaction_product.created_at,transaction_product.updated_at,gambar');
        $this->db->from('transaction_product');
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("transaction_product.userid =",$userid);
		$this->db->where("transaction_product.status <>","Pending");
        $this->db->where('transaction_product.created_at >',$created_at);
		$query=$this->db->get();
        return $query->result();
    }

    function getTransactionSyncUpdated($updated_at,$userid){
        $this->db->select('transactionid,productname,price as harga,quantity,transaction_product.status,transaction_product.created_at,transaction_product.updated_at,gambar');
        $this->db->from('transaction_product');
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("transaction_product.userid",$userid);
		$this->db->where("transaction_product.status <>","Pending");
        $this->db->where('transaction_product.updated_at >',$updated_at);
		$query=$this->db->get();
        return $query->result();
    }
	
	
	public function getOrderByUserId($userid){
        $this->db->select("transaction_product.transactionid , product.productid , product.productname,transaction_product.price as harga,transaction_product.quantity,transaction_product.created_at,product.gambar");
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
		$this->db->order_by("created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	 function updateStatus($status){
        $data= array('status' => $status);
        $this->db->where('transactionid',$transactionid);
        if($this->db->update('transaction_product',$data))
            return true;
        else
            return false;
    }
	
	
	function getTransactionsSyncCreated($userid,$created_at){
        $this->db->select('*');
        $this->db->from('transaction_product');
        $this->db->where('created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }

    function getTransactionsSyncUpdated($userid,$updated_at){
        $this->db->select('*');
        $this->db->from('transaction_product');
        $this->db->where('updated_at >',$updated_at);
        $query=$this->db->get();
        return $query->result();
    }

}