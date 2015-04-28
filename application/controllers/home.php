<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$this->load->view('view',array('user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}
	
	
	public function product()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('product', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else
			echo "<script>window.location.href='".base_url('signin')."'</script>";
	}
	
	public function user()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('user', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}
	
	public function order()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('transaction', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}
	
	public function recapitulation()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('recapitulation', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}
	
	public function report()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('report', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}


	
	public function message()
	{
	
		$this->load->library('session');
		$user=$this->session->userdata('user');
		if($user){
			$view_child=$this->load->view('message', '', true);
			$this->load->view('view',array('view_child'=>$view_child,'user'=>$user));
		}
		else{
			echo "<script>window.location.href='".base_url('signin/')."'</script>";
		}
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */