<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'user_model' );
		$this->load->helper('form');
	}

	public function index()
	{
		$this->load->view('main/index');
	}

	public function signup()
	{
		$data[ 'error' ] = '';
		$this->load->view('main/header');
		$this->load->view('main/signup', $data);
		$this->load->view('main/footer');
	}

	public function signin()
	{
		// Check if user is logged in
		if($this->session->userdata('user_name') != '') {
			$this->dashboard();
		} else {
			$data['error'] = '';
			$this->load->view('main/header');
			$this->load->view('main/signin', $data);
			$this->load->view('main/footer');
		}
	}

	public function registration()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->user_model->add_user();
			$this->dashboard();
		}
	}

	public function login()
	{
		$email=$this->input->post('email');
		$password=md5($this->input->post('pass'));

		$result=$this->user_model->login($email,$password);
		if($result) {
			// Successfully logged in
			$this->dashboard();
		}else {
			p('Guild:: Login Failed');
			$this->signin();
		}
	}

	private function dashboard()
	{
		$this->load->view('main/header');
		$this->load->view('main/dashboard');
		$this->load->view('main/footer');
	}

	public function logout()
	{
		$newdata = array(
		'user_id'   =>'',
		'user_name'  =>'',
		'user_email'     => '',
		'logged_in' => FALSE
	);
		$this->session->unset_userdata($newdata );
		$this->session->sess_destroy();
		$this->index();
	}
}
