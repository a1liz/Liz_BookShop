<?php

require("tools.php");

class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('sign_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index() {
		echo "api/User";
	}

	/**
     * use to make a info
     *
     * @param int $Flag - the flag
     * @param string $Content -the content
     * @param string $Extra -the extra info
     * @return array
     */
    private function getInfo($Flag = 100,$Content = "",$Extra = ""){
      $info = array("Flag" => $Flag,"Content" => $Content,"Extra" => $Extra);
      return $info;
    }


    /**
     * used to signIn
     */
    public function signIn(){
      $account = $_POST['Account'];
      $password = $_POST['Password'];
      //在数据库中查找是否有该账号以及检查该账号是否可用
      $state = $this->sign_model->CheckAccount($account,$password);

      $info = null;

      
      //可以登陆
      if($state === 1){
         $userinfomation = $this->sign_model->GetUserInfo($account);
         //$this->session->set_userdata($userinfomation);
         $this->session->userdata['info'] = $userinfomation;
         $info = $this->getInfo(100,"sign in success",json_encode($this->session->userdata['info'][0]));
         //print_r($this->session->userdata['info'][0]);
      }
      //出现错误
      else {
          $info = $this->getInfo(-1,"error","");
      }
      
      echo urldecode(json_encode($info));
    }

    /**
    * 返回session
    */
    public function GetSession(){
      $info = null;
      if($this->session->userdata['info'][0]){
        $info = $this->getInfo(100,"success",json_encode($this->session->userdata['info'][0]));
      }
      echo urldecode(json_encode($info));
    }


}