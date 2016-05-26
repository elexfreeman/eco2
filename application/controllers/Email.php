<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Email extends CI_Controller {

	/*���������� ��� ������ � view*/
	public $data;



	public function __construct()
	{
		date_default_timezone_set('Europe/London');
		parent::__construct();
		/*���������  ���������� ������*/
		$this->load->library('session');
		/*��������� ������*/
		$this->load->model('auth_model');
		$this->load->model('nrk_model');
		/*���������� �������*/
		$this->load->helper('form');
		$this->load->helper('url');

		/*������ ��� � ��� ������������ ��������� �� ������*/
		$this->data['logout_url']=$this->auth_model->GetLogoutUrl();
		$this->data['user_name']=$this->auth_model->GetloginUser();
	}


	/*����� ��������*/
	public function index()
	{
		/*���� ���������*/
		if($this->auth_model->IsLogin())
		{

		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}

	public function form($patient_id)
	{

		/*���� ���������*/
		if($this->auth_model->IsLogin())
		{
			if($this->input->post('action')=='email_send')
			{

				///$this->nrk_model->add($this->input->post());
				header('Location: '.base_url());
				exit;

			}
			else
			{
				$this->data['direction']=$this->nrk_model->get_list_directions($patient_id);

				$this->load->view('head',$this->data);
				$this->load->view('navbar',$this->data);
				$this->load->view('patients/email_form',$this->data);
				$this->load->view('footer',$this->data);
			}


		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}


}
