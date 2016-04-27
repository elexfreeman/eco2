<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Класс авторизазции*/

class Auth_model extends CI_Model
{
    /*Таблица с логинами*/
    public $auth_table = 'AKTPAK..pit_userlist';
    public $user_group = 'mz_admin_direction';

    public function __construct()
    {

        $this->load->database();

        $this->load->helper('url');
    }

    public function GetAllUSers()
    {
        $sql="SELECT * FROM ".$this->auth_table."
        WHERE
        ([type]='".$this->user_group."')
";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function IsLogin()
    {
        if($this->session->has_userdata('username'))
        {
            return true;
        }
        else return false;
    }

    /*Проверка на существование юзера*/
    public function  GetUserByNameAndPass($username,$password)
    {
        /*Вычищаем*/
        $username = $this->security->xss_clean($username);
        $password = $this->security->xss_clean($password);

        $sql="SELECT * FROM ".$this->auth_table."
        WHERE
        ([user]='".$username."')
        and([pass]='".$password."')
        and([type]='".$this->user_group."')
";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*выдает имя зареганого пользователя*/
    function GetloginUser()
    {
        if($this->IsLogin())
        {
            return $this->session->username;
        }
        else return false;
    }

    function GetLogoutUrl()
    {
        return base_url('auth/logout');
    }




}