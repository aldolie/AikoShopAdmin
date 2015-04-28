<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_master extends CI_Model {

    var $productid      = '';
    var $productname    = '';
    var $categoryid     = '';
    var $hargaeceran    = '';
    var $hargagrosir    = '';
    var $stock          = '';
    var $gambar         = '';
    var $description    = '';
    var $created_at     = '';
    var $updated_at     = '';
    var $published_at   = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function getProducts($method){
        if($method==0){
            $this->db->select('*');
		}
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,stock,gambar,description,created_at,updated_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,stock,gambar,description,created_at,updated_at');
        $this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
        $query=$this->db->get();
        return $query->result();
    }


    function getProduct($id)
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('productid',$id);
        $query=$this->db->get();
        $data=$query->result();
        if($data)
            return $data[0];
        else
            return null;
    }


	function getProductsForAdmin($offset,$limit,$cat,$search){
		$this->db->select('*');
	    $this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
		$this->db->like($cat, $search);
		$this->db->limit($limit, $offset);
		$query=$this->db->get();
        return $query->result();
    }
	
	function getProductsForAdminCount($offset,$limit,$cat,$search){
		$this->db->select('*');
	    $this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
        $this->db->like($cat, $search);
		$this->db->limit($limit, $offset);
		$query=$this->db->get();
        return count($query->result());
    }
	
    function getProductsForCustomer($offset,$limit){
         $this->db->select('productid,productname,hargagrosir as harga,stock,gambar,description,created_at,published_at');
         $this->db->from('product');
         $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		 $this->db->where('`deleted_at` IS  NULL', NULL, FALSE);		 
         $this->db->order_by("created_at", "desc");
		 $this->db->limit($limit, $offset);
         $query=$this->db->get();
         return $query->result();
    }
	
	function getProductsForCustomerCount($offset,$limit){
         $this->db->select('productid,productname,hargagrosir as harga,stock,gambar,description,created_at,published_at');
         $this->db->from('product');
         $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
         $this->db->where('`deleted_at` IS  NULL', NULL, FALSE);		 
         $this->db->order_by("created_at", "desc"); 
         $this->db->limit($limit, $offset);
		 $query=$this->db->get();
        return count($query->result());
    }

     function getProductsSyncCreated($created_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,stock,gambar,description,created_at,updated_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,stock,gambar,description,created_at,updated_at');
        
        $this->db->from('product');
        $this->db->where('created_at >',$created_at);
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
        $query=$this->db->get();
        return $query->result();
    }

    function getProductsSyncUpdated($updated_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,gambar,stock,description,created_at,updated_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,gambar,stock,description,created_at,updated_at');
        $this->db->from('product');
        $this->db->where('updated_at >',$updated_at);
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
        $query=$this->db->get();
        return $query->result();
    }


    function insertProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,$stock){
        $newObject=new Product_master;
        $newObject->productid=NULL;
        $newObject->productname=$productname;
        $newObject->categoryid=$categoryid;
        $newObject->hargaeceran=$hargaeceran;
        $newObject->hargagrosir=$hargagrosir;
        $newObject->description=$description;
        $newObject->stock=$stock;
        $newObject->gambar=NULL;
        $newObject->created_at=date("Y-m-d H:i:s");
        $newObject->updated_at=NULL;
        $newObject->published_at=NULL;
        if($this->db->insert('product',$newObject)){
            $id=$this->db->insert_id();
            return $this->getProduct($id);
        }
        else 
            return null;
    }


    function updateProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,$stock,$productid){
        $data= array('productname' => $productname,
                     'categoryid' => $categoryid,
                     'hargaeceran' =>$hargaeceran,
                     'hargagrosir' =>$hargagrosir,
                     'description' =>$description,
                     'stock'=>$stock
                    );
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	
	function publishProduct($productid){
        $data= array('published_at' => date("Y-m-d H:i:s"));
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	
	function deleteProduct($productid){
        $data= array('deleted_at' => date("Y-m-d H:i:s"));
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }

	function updateStockProduct($stock,$productid){
        $data= array('stock'=>$stock);
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	

    function updateProductImage($gambar,$productid){
        $data= array('gambar' => $gambar
                    );
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }

    function getPriceGrosir($productid){
        $this->db->select('hargagrosir as harga');
        $this->db->from('product');
        $this->db->where('productid',$productid);
        $query=$this->db->get();
        $products= $query->result();
        return $products[0]->harga;
    }
	
	function getStock($productid){
        $this->db->select('stock');
        $this->db->from('product');
        $this->db->where('productid',$productid);
        $query=$this->db->get();
        $products= $query->result();
        return $products[0]->stock;
    }

}