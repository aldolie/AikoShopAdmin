<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller {

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
		if(!$user){
			$this->load->view('signin');
		}
		else{
			echo "<script>window.location.href='".base_url('home/product')."'</script>";
		}
	}
	
	public function action(){
		
		$this->load->library('session');
		$username='';
		$password='';
		if($this->input->post('username')){
			$username=$this->input->post('username');
		}
		if($this->input->post('password'))
			$password=$this->input->post('password');
		if($username=='')
		{
			$this->load->view('signin',array('error'=>'Username harus diisi'));
		}
		else if($password==''){
			$this->load->view('signin',array('error'=>'Password harus diisi'));
		}
		else
		{
			$curl_handle=curl_init(); 
			curl_setopt($curl_handle, CURLOPT_URL, 'http://104.199.129.2/aiko/index.php/services/staff_signin/');
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
				'username' => $username,
				'password' => $password
			));
		   curl_setopt($curl_handle, CURLOPT_USERPWD, 'administrator'	   . ':' . 'KJHASDF89.ajHFAHF$');
	  
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);
			$result = json_decode($buffer);
			if(isset($result->status)&&$result->status=='success'){
				$this->session->set_userdata('user',$result->result);
				echo "<script>window.location.href='".base_url('home/product')."'</script>";
			}
			else{
				$this->load->view('signin',array('error'=>$result->result));
			}
		}
		
		
	}
	
	
	public function deaction(){
		
		$this->load->library('session');
		$this->session->unset_userdata('user');
		echo "<script>window.location.href='".base_url('signin')."'</script>";
		
		
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */