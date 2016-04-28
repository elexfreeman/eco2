<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

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
			if($this->input->post('action')=='all')
			{

				$this->data['res']=$this->nrk_model->search($this->input->post());
				$this->load->view('search_result',$this->data);
			}
			else
			{
				$this->data['res']=$this->nrk_model->search($this->input->post());
				$this->load->view('search_result',$this->data);
			}
		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}

	public function add()
	{
		/*Если залогинен*/
		if($this->auth_model->IsLogin())
		{
			if($this->input->post('action')=='add')
			{
				$this->nrk_model->add($this->input->post());
				header('Location: '.base_url());
				exit;

			}
			else
			{
				$this->data['eco_lpu']=$this->nrk_model->get_eco_lpu();
				$this->data['funding']=$this->nrk_model->get_funding();
				$this->data['type_obr']=$this->nrk_model->get_type_obr();
				$this->load->view('head',$this->data);
				$this->load->view('navbar',$this->data);
				$this->load->view('patients/add',$this->data);
				$this->load->view('footer',$this->data);
			}


		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}

	public function edit($id)
	{
		/*Если залогинен*/
		if($this->auth_model->IsLogin())
		{
			if($this->input->post('action')=='update')
			{
				$this->nrk_model->update($this->input->post());
				header('Location: '.base_url());
				exit;
			}
			else
			{
				$this->data['id']=$this->security->xss_clean($id);
				$this->data['eco_lpu']=$this->nrk_model->get_eco_lpu();
				$this->data['funding']=$this->nrk_model->get_funding();
				$this->data['type_obr']=$this->nrk_model->get_type_obr();
				$this->data['dir']=$this->nrk_model->get_dir($id);
				$this->data['id']=$id;
				if(count($this->data['dir'])>0)
				{
					$this->load->view('head',$this->data);
					$this->load->view('navbar',$this->data);
					$this->load->view('patients/edit',$this->data);
					$this->load->view('footer',$this->data);
				}
				else
				{
					header('Location: '.base_url('auth'));
					exit;
				}
			}


		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}


	/*Направить в лпу вставить запись*/
	/*$id - номер направления*/
	public function tolpuadd($id)
	{
		/*Если залогинен*/
		if($this->auth_model->IsLogin())
		{
			if($this->input->post('action')=='tolpuadd')
			{
				$this->nrk_model->dir_lpu_update($this->input->post());
				header('Location: '.base_url());
				exit;
			}
			else
			{
				$this->data['id']=$this->security->xss_clean($id);
				$this->data['eco_lpu']=$this->nrk_model->get_eco_lpu();
				$this->data['funding']=$this->nrk_model->get_funding();
				$this->data['type_obr']=$this->nrk_model->get_type_obr();
				$this->data['dir']=$this->nrk_model->get_dir($id);
				$this->data['tolpu']=$this->nrk_model->get_to_lpu($id);
				$this->data['id']=$id;
				if(count($this->data['dir'])>0)
				{
					$this->load->view('head',$this->data);
					$this->load->view('navbar',$this->data);
					$this->load->view('patients/tolpuupdate',$this->data);
					$this->load->view('footer',$this->data);
				}
				else
				{
					header('Location: '.base_url('auth'));
					exit;
				}
			}
		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}

	public function tolpuedit($id)
	{
		/*Если залогинен*/
		if($this->auth_model->IsLogin())
		{
			if($this->input->post('action')=='tolpuedit')
			{
				$this->nrk_model->dir_lpu_update($this->input->post());
				header('Location: '.base_url());
				exit;
			}
			else
			{
				$this->data['id']=$this->security->xss_clean($id);
				$this->data['eco_lpu']=$this->nrk_model->get_eco_lpu();
				$this->data['funding']=$this->nrk_model->get_funding();
				$this->data['type_obr']=$this->nrk_model->get_type_obr();
				$this->data['dir']=$this->nrk_model->get_dir($id);
				$this->data['tolpu']=$this->nrk_model->get_to_lpu($id);
				$this->data['id']=$id;
				if(count($this->data['dir'])>0)
				{
					$this->load->view('head',$this->data);
					$this->load->view('navbar',$this->data);
					$this->load->view('patients/tolpuupdate',$this->data);
					$this->load->view('footer',$this->data);
				}
				else
				{
					header('Location: '.base_url('auth'));
					exit;
				}
			}
		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}
	}
}
