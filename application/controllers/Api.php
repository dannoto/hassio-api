<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('adeptos_model');
		$this->load->model('adeptos_inline_model');
		$this->load->model('adeptos_outline_model');
	}

	// ADD

	public function add_adepto_main()
	{

		$response = array();

		$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));

		if (!preg_match("~^(?:f|ht)tps?://~i", $data['adepto_site'])) {

			$data['adepto_site'] = "http://" . $data['adepto_site'];
		}
		
		$data['adepto_site'] = parse_url($data['adepto_site'], PHP_URL_HOST);
		$data['adepto_site'] = preg_replace('/^www\./', '', $data['adepto_site']);
		$data['adepto_site'] = $data['adepto_site'];

		$data['adepto_active'] = htmlspecialchars($this->input->get('adepto_active'));
		$data['adepto_data_created']  = date('Y-m-d H:i:s');
		$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		$data['adepto_cms'] = htmlspecialchars($this->input->get('adepto_cms'));
		$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		$data['adepto_persistence_check'] = htmlspecialchars($this->input->get('adepto_persistence_check'));
		$data['adepto_js_check'] = htmlspecialchars($this->input->get('adepto_persistence_check'));
		$data['is_deleted'] = 1;


		if ($this->adeptos_model->check_adepto_main_by_site($data['adepto_site'])) {

			$response = array(
				'status' => false,
				'message' => "Adepto already exist."
			);
		} else {

			$this->adeptos_model->add_adepto_main($data);

			$response = array(
				'status' => true,
				'message' => "Adepto successfully created."
			);
		}

		print_r(json_encode($response));
	}

	public function add_adepto_inline()
	{

		$response = array();

		$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));

		if (!preg_match("~^(?:f|ht)tps?://~i", $data['adepto_site'])) {

			$data['adepto_site'] = "http://" . $data['adepto_site'];
		}
		
		$data['adepto_site'] = parse_url($data['adepto_site'], PHP_URL_HOST);
		$data['adepto_site'] = preg_replace('/^www\./', '', $data['adepto_site']);
		$data['adepto_site'] = $data['adepto_site'];

		$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		// $data['adepto_vulnerable'] = htmlspecialchars($this->input->get('adepto_vulnerable'));
		$data['adepto_cms'] = htmlspecialchars($this->input->get('adepto_cms'));
		$data['adepto_cms_method'] = htmlspecialchars($this->input->get('adepto_cms_method'));

		$data['adepto_cms_login'] = htmlspecialchars($this->input->get('adepto_cms_login'));
		$data['adepto_cms_password'] = htmlspecialchars($this->input->get('adepto_cms_password'));

		$data['adepto_data_created']  = date('Y-m-d H:i:s');
		$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		$data['is_deleted'] = 1;


		if ($this->adeptos_inline_model->check_adepto_inline_by_site($data['adepto_site'], $data['adepto_cve'])) {

			$response = array(
				'status' => false,
				'message' => "Adepto Inline already exist."
			);
		} else {

			$this->adeptos_inline_model->add_adepto_inline($data);

			$response = array(
				'status' => true,
				'message' => "Adepto Inline successfully created."
			);
		}

		print_r(json_encode($response));
	}

	public function add_adepto_outline()
	{

		$response = array();

		$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));

		if (!preg_match("~^(?:f|ht)tps?://~i", $data['adepto_site'])) {

			$data['adepto_site'] = "http://" . $data['adepto_site'];
		}

		$data['adepto_site'] = parse_url($data['adepto_site'], PHP_URL_HOST);
		$data['adepto_site'] = preg_replace('/^www\./', '', $data['adepto_site']);
		$data['adepto_site'] = $data['adepto_site'];

		$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		$data['adepto_vulnerable'] = htmlspecialchars($this->input->get('adepto_vulnerable'));
		$data['adepto_data_created'] = date('Y-m-d H:i:s');
		$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		$data['is_deleted'] = 1;


		if ($this->adeptos_outline_model->check_adepto_outline_by_site($data['adepto_site'], $data['adepto_cve'])) {

			$response = array(
				'status' => false,
				'message' => "Adepto outline already exist."
			);
		} else {

			$this->adeptos_outline_model->add_adepto_outline($data);

			$response = array(
				'status' => true,
				'message' => "Adepto outline successfully created."
			);
		}

		print_r(json_encode($response));
	}

	// GET

	public function get_adeptos_mains()
	{

		$response = array();
		$data = array();

		if (htmlspecialchars($this->input->get('adepto_persistence'))) {

			$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		}


		if (htmlspecialchars($this->input->get('adepto_active'))) {

			$data['adepto_active'] = htmlspecialchars($this->input->get('adepto_active'));
		}

		if (htmlspecialchars($this->input->get('adepto_cve'))) {

			$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		}

		if ($res = $this->adeptos_model->get_adeptos_mains($data['adepto_persistence'], $data['adepto_cve'], $data['adepto_active'])) {

			$response = array(
				'status' => true,
				'data' => $res,
				'message' => "Adepto main found."
			);
		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos main not founds."
			);
		}

		print_r(json_encode($response));
	}

	public function get_adeptos_inlines()
	{

		$response = array();

		if (htmlspecialchars($this->input->get('adepto_processed'))) {

			$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		}

		if (htmlspecialchars($this->input->get('adepto_persistence'))) {

			$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		}

		if (htmlspecialchars($this->input->get('adepto_cve'))) {

			$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		}

		if ($res =$this->adeptos_inline_model->get_adeptos_inlines($data['adepto_processed'], $data['adepto_cve'], $data['adepto_persistence'])) {

			$response = array(
				'status' => true,
				'data' => $res,
				'message' => "Adepto inlines found."
			);
		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos inlines not founds."
			);
		}

		print_r(json_encode($response));
	}

	public function get_adeptos_outlines()
	{

		$response = array();

		if (htmlspecialchars($this->input->get('adepto_processed'))) {

			$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		}

		if (htmlspecialchars($this->input->get('adepto_cve'))) {

			$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		}

		if ($res = $this->adeptos_outline_model->get_adeptos_outlines($data['adepto_processed'], $data['adepto_cve'])) {

			$response = array(
				'status' => true,
				'data' => $res,
				'message' => "Adepto outlines found."
			);
		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos outlines not founds."
			);
		}

		print_r(json_encode($response));
	}

	// UPDATE


	public function update_adepto_main()
	{

		$response = array();
		$data= array();

		$id = $this->input->get('id');

		if (htmlspecialchars($this->input->get('adepto_site'))) {

			$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));
		}

		if (htmlspecialchars($this->input->get('adepto_active'))) {

			$data['adepto_active'] = htmlspecialchars($this->input->get('adepto_active'));
		}

		if (htmlspecialchars($this->input->get('adepto_data_created'))) {

			$data['adepto_data_created'] = htmlspecialchars($this->input->get('adepto_data_created'));
		}

		if (htmlspecialchars($this->input->get('adepto_cve'))) {

			$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		}

		if (htmlspecialchars($this->input->get('adepto_cms'))) {

			$data['adepto_cms'] = htmlspecialchars($this->input->get('adepto_cms'));
		}

		if (htmlspecialchars($this->input->get('adepto_persistence'))) {

			$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		}

		if (htmlspecialchars($this->input->get('adepto_persistence_check'))) {

			$data['adepto_persistence_check'] = htmlspecialchars($this->input->get('adepto_persistence_check'));
		}

		if (htmlspecialchars($this->input->get('adepto_js_check'))) {

			$data['adepto_js_check'] = htmlspecialchars($this->input->get('adepto_js_check'));
		}

		if (htmlspecialchars($this->input->get('is_deleted'))) {

			$data['is_deleted'] = htmlspecialchars($this->input->get('is_deleted'));
		}

		if ($this->adeptos_model->update_adepto_main($id, $data)) {

			$response = array(
				'status' => true,
				'data' => $data,
				'message' => "Adepto main updated successfulled."
			);

		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos main not updated."
			);
		}

		print_r(json_encode($response));
	}

	public function update_adepto_inline()
	{

		$response = array();
		$data = array();

		$id = $this->input->get('id');

		if (htmlspecialchars($this->input->get('adepto_site'))) {

			$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));
		}

		if (htmlspecialchars($this->input->get('adepto_processed'))) {

			$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		}

			if (htmlspecialchars($this->input->get('adepto_persistence'))) {

			$data['adepto_persistence'] = htmlspecialchars($this->input->get('adepto_persistence'));
		}

		if (htmlspecialchars($this->input->get('adepto_persistence_log'))) {

			$data['adepto_persistence_log'] = htmlspecialchars($this->input->get('adepto_persistence_log'));
		}

			if (htmlspecialchars($this->input->get('adepto_cms'))) {

			$data['adepto_cms'] = htmlspecialchars($this->input->get('adepto_cms'));
		}

		if (htmlspecialchars($this->input->get('adepto_cms_method'))) {

			$data['adepto_cms_method'] = htmlspecialchars($this->input->get('adepto_cms_method'));
		}

			if (htmlspecialchars($this->input->get('adepto_cms_login'))) {

			$data['adepto_cms_login'] = htmlspecialchars($this->input->get('adepto_cms_login'));
		}

		if (htmlspecialchars($this->input->get('adepto_cms_password'))) {

			$data['adepto_cms_password'] = htmlspecialchars($this->input->get('adepto_cms_password'));
		}



		if (htmlspecialchars($this->input->get('is_deleted'))) {

			$data['is_deleted'] = htmlspecialchars($this->input->get('is_deleted'));
		}


		if ($this->adeptos_inline_model->update_adepto_inline($id, $data)) {

			$response = array(
				'status' => true,
				'data' => $data,
				'message' => "Adepto inline updated successfulled."
			);

		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos inline not updated."
			);
		}

		print_r(json_encode($response));
	}

	public function update_adepto_outline()
	{

		$response = array();
		$data = array();

		$id = $this->input->get('id');

		if (htmlspecialchars($this->input->get('adepto_site'))) {

			$data['adepto_site'] = htmlspecialchars($this->input->get('adepto_site'));
		}

		if (htmlspecialchars($this->input->get('adepto_processed'))) {

			$data['adepto_processed'] = htmlspecialchars($this->input->get('adepto_processed'));
		}

		if (htmlspecialchars($this->input->get('adepto_vulnerable'))) {

			$data['adepto_vulnerable'] = htmlspecialchars($this->input->get('adepto_vulnerable'));
		}

		if (htmlspecialchars($this->input->get('adepto_data_created'))) {

			$data['adepto_data_created'] = htmlspecialchars($this->input->get('adepto_data_created'));
		}

		if (htmlspecialchars($this->input->get('adepto_cve'))) {

			$data['adepto_cve'] = htmlspecialchars($this->input->get('adepto_cve'));
		}

		if (htmlspecialchars($this->input->get('is_deleted'))) {

			$data['is_deleted'] = htmlspecialchars($this->input->get('is_deleted'));
		}

		if ($this->adeptos_outline_model->update_adepto_outline($id, $data)) {

			$response = array(
				'status' => true,
				'data' => $data,
				'message' => "Adepto outline updated successfulled."
			);
			
		} else {

			$response = array(
				'status' => false,
				'data' => array(),
				'message' => "Adeptos outline not updated."
			);
		}

		print_r(json_encode($response));

	
	}
}
