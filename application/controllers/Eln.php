<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eln extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;

	public function __construct()
	{
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

	public function index()
	{
		/*Если залогинен*/
		if($this->auth_model->IsLogin())
		{
			$this->data['count']=$this->nrk_model->get_info_count();
			$this->load->model('mainpage_model');
			$this->load->view('head',$this->data);
			$this->load->view('navbar',$this->data);
			$this->load->view('eln_main',$this->data);
			$this->load->view('footer',$this->data);
		}
		/*Иначе редиректим на auth form*/
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}

}
