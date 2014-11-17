<?php
	if( !defined('BASEPATH') ) {
		exit( 'No direct script access allowed' );
	}

	class User_model extends CI_Model {
		public function __construct()
		{
			parent::__construct();
		}

		function add_user()
		{
			$data = array(
				'username' => $this->input->post('user_name'),
				'email' => $this->input->post('email_address'),
				'role' => 'Designer',
				'password' => md5($this->input->post('password'))
			);
			$this->db->insert( 'User' , $data);
		}

		function login($email,$password)
		{
		$this->db->where("email", $email);
		$this->db->where("password", $password);
		$query = $this->db->get("User");
		if($query->num_rows() == 1)
		{
			//p('Found rows:'.$query->num_rows());
			foreach($query->result() as $rows)
			{
				//add all data to session
				$newdata = array(
				  'user_id'  => $rows->Id,
				  'user_name'  => $rows->Username,
				  'user_email' => $rows->Email,
				  'user_role' => $rows->Role,
				  'logged_in'  => TRUE,
				);
			}
				$this->session->set_userdata($newdata);
				return true;
			}
			return false;
		}
	}