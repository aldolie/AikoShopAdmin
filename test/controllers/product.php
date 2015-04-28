<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('product_master');
		$data=$this->product_master->getProducts(0);
		$this->load->view('product',array('data'=>$data));
		
	}
	
	
	public function update($id)
	{
		$this->load->model('product_master');
		$data=$this->product_master->getProduct($id);
		$this->load->model('category');
		$category=$this->category->getCategories();
		$this->load->view('product_update',array('data'=>$data,'categories'=>$category));
		
	}
	
	
	public function upload($id)
	{
		$this->load->model('product_master');
		$data=$this->product_master->getProduct($id);
		$this->load->view('product_upload',array('data'=>$data));
		
	}
	
	public function insert()
	{
		$this->load->model('category');
		$category=$this->category->getCategories();
		$this->load->view('product_insert',array('data'=>$category));
		
	}
	
	
	public function insert_action(){
		$this->load->model('product_master');
		$this->load->model('category');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Product Name', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required|integer');
		$this->form_validation->set_rules('grosir', 'Harga Grosir', 'required|integer');
		$this->form_validation->set_rules('eceran', 'Harga Eceran', 'required|integer');
		$this->form_validation->set_rules('description', 'Deskripsi', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{
			$categories=$this->category->getCategories();
			$this->load->view('product_insert',array('data'=>$categories));
		}
		else
		{
			$name=$this->input->post('name');
			$category=$this->input->post('category');
			$grosir=$this->input->post('grosir');
			$eceran=$this->input->post('eceran');
			$stock=$this->input->post('stock');
			$desc=$this->input->post('description');
			$obj=$this->product_master->insertProduct($name,$category,$eceran,$grosir,$desc,$stock);
			if($obj){
				$categories=$this->category->getCategories();
				$this->load->view('product_insert',array('data'=>$categories));
			}
			else{
				$categories=$this->category->getCategories();
				$this->load->view('product_insert',array('data'=>$categories));
			}
		}
		
	}
	
	public function update_action($id)
	{
		$this->load->model('product_master');
		$this->load->model('category');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('name', 'Product Name', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required|integer');
		$this->form_validation->set_rules('grosir', 'Harga Grosir', 'required|integer');
		$this->form_validation->set_rules('eceran', 'Harga Eceran', 'required|integer');
		$this->form_validation->set_rules('description', 'Deskripsi', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$data=$this->product_master->getProduct($id);
			$categories=$this->category->getCategories();
			$this->load->view('product_update',array('data'=>$data,'categories'=>$categories));
		}
		else
		{
		
			
			$id_t=$this->input->post('id');
			$name=$this->input->post('name');
			$category=$this->input->post('category');
			$grosir=$this->input->post('grosir');
			$eceran=$this->input->post('eceran');
			$stock=$this->input->post('stock');
			$desc=$this->input->post('description');
			$obj=$this->product_master->updateProduct($name,$category,$eceran,$grosir,$desc,$stock,$id_t);
			if($obj){
				$data=$this->product_master->getProduct($id);
				$categories=$this->category->getCategories();
				$this->load->view('product_update',array('data'=>$data,'categories'=>$categories));
			}
			else{
				$data=$this->product_master->getProduct($id);
				$categories=$this->category->getCategories();
				$this->load->view('product_update',array('data'=>$data,'categories'=>$categories));
			}
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */