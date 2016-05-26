<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Email extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;



	public function __construct()
	{
		date_default_timezone_set('Europe/London');
		parent::__construct();
		/*Загружаем  библиотеку сессий*/
		$this->load->library('session');
		/*Загружаем модели*/
		$this->load->model('auth_model');
		$this->load->model('nrk_model');
		/*Закгружаем хелперы*/
		$this->load->helper('form');
		$this->load->helper('url');

		/*Логоут урл и имя пользователя выводятся из модели*/
		$this->data['logout_url']=$this->auth_model->GetLogoutUrl();
		$this->data['user_name']=$this->auth_model->GetloginUser();
	}


	/*Поиск аяксовый*/
	public function index()
	{
		/*Если залогинен*/
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

		/*Если залогинен*/
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
