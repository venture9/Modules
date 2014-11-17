<?php

	if ( !defined( 'BASEPATH' ) )
	{
		exit( 'No direct script access allowed' );
	}

	class Designer extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->helper('form');
		}

		public function index() {
			$this->load->view( 'designer/index' );
		}

		public function upload_catalog() {
			$data[ 'error' ] = '';
			$this->load->view( 'designer/upload_catalog', $data );
		}

		public function upload_files() {
			$this->load->view( 'desinger/upload_files' );
		}

		public function do_upload()
		{
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());

				$this->load->view('designer/upload_catalog', $error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				$this->load->view('designer/upload_success', $data);
			}
		}
	}