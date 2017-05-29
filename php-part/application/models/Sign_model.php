
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Sign_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$id=0;
	}
	
	
	/**
	*	根据账号返回用户信息作为session
	*	@param Account varchar(40)
	*/
	public function GetUserInfo($account){
		$sql = "SELECT * FROM Employees WHERE cid = ".$this->db->escape($account);
		return $this->db->query($sql)->result_array();
	}

	/**
	*  检查账号：传入账号，返回数据库中是否已经存在该账号
	*
	*	@param account varcahr(40) 
	*	@return true->账号已经存在， false->账号不存在
	*/
	public function AccountExist($account=0){
		$query = $this->db->get_where("Employees",array("cid" => $account));
		//数据库中有记录表示该账号已经存在
		if($query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	*	检查文档：登陆时查找数据库中是否有该账号和密码
	*	@param account varchar(40)
	*	@param password varchar(20)
	*	@return 0->错误，1->正常
	*/
	public function CheckAccount($account,$password){	
		//账号存在,检查密码是否正确
		$query = $this->db->query("select * from Employees where cid = '$account' ");
		//echo $query->num_rows();
		if($query->num_rows() <> 0){
			//有该账号，检查密码是否正确
			foreach($query->result() as $row){
				//密码正确
				if($row->password === $password){
					return 1;
				}
			}
		}
		// error
		else{
			return 0;
		}
	}
	
}
	
?>
