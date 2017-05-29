<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Books_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function addBooks($ISBN,$pressname,$IDcardnumber,$bookname,$price,$publicationtime) {
		$sql = "INSERT INTO Books(ISBN,pressname,IDcardnumber,bookname,price,publicationtime) VALUES(".$this->db->escape($ISBN).",".$this->db->escape($pressname).",".$this->db->escape($IDcardnumber).",".$this->db->escape($bookname).",".$this->db->escape($price).",".$this->db->escape($publicationtime).")";

		return $this->db->query($sql);
	}

	public function addAuthor($IDcardnumber,$authorname) {
		$sql = "INSERT INTO Author(IDcardnumber,authorname) VALUES(".$this->db->escape($IDcardnumber).",".$this->db->escape($authorname).")";

		return $this->db->query($sql);
	}

	public function addCustomer($cid,$cname,$score,$registrationtime,$birthday,$gender,$phonenumber) {
		$sql = "INSERT INTO Customer(cid,cname,score,registrationtime,birthday,gender,phonenumber) VALUES(".$this->db->escape($cid).",".$this->db->escape($cname).",".$this->db->escape($score).",".$this->db->escape($registrationtime).",".$this->db->escape($birthday).",".$this->db->escape($gender).",".$this->db->escape($phonenumber).")";

		return $this->db->query($sql);
	}

	public function addEmployees($eid,$shopid,$ename,$salary,$entrytime) {
		$sql = "INSERT INTO Employees(eid,shopid,ename,salary,entrytime) VALUES(".$this->db->escape($eid).",".$this->db->escape($shopid).",".$this->db->escape($ename).",".$this->db->escape($salary).",".$this->db->escape($entrytime).")";
		return $this->db->query($sql);
	}

	public function addFocus($cid,$ISBN) {
		$sql = "INSERT INTO Focus(cid,ISBN) VALUES(".$this->db->escape($cid).",".$this->db->escape($ISBN).")";
		return $this->db->query($sql);
	}

	public function addPress($pressname,$editor,$addr) {
		$sql = "INSERT INTO Press(pressname,editor,addr) VALUES(".$this->db->escape($pressname).",".$this->db->escape($editor).",".$this->db->escape($addr).")";

		return $this->db->query($sql);
	}

	public function addPurchase($cid,$ISBN,$shopid,$purchasenumber,$purchasedate) {
		$sql = "INSERT INTO Purchase(cid,ISBN,shopid,purchasenumber,purchasedate) VALUES(".$this->db->escape($cid).",".$this->db->escape($ISBN).",".$this->db->escape($shopid).",".$this->db->escape($purchasenumber).",".$this->db->escape($purchasedate).")";

		return $this->db->query($sql);
	}

	public function addShops($shopid,$address,$opendate,$manager) {
		$sql = "INSERT INTO Shops(shopid,address,opendate,manager) VALUES(".$this->db->escape($shopid).",".$this->db->escape($address).",".$this->db->escape($opendate).",".$this->db->escape($manager).")";

		return $this->db->query($sql);
	}

	public function addStockIn($ISBN,$eid,$shopid,$stockinnumber,$stockindate) {
		$sql = "INSERT INTO StockIn(ISBN,eid,shopid,stockinnumber,stockindate) VALUES(".$this->db->escape($ISBN).",".$this->db->escape($eid).",".$this->db->escape($shopid).",".$this->db->escape($stockinnumber).",".$this->db->escape($stockindate).")";

		return $this->db->query($sql);
	}

	public function addStorage($ISBN,$shopid,$storagenumber) {
		$sql = "INSERT INTO Storage(ISBN,shopid,storagenumber) VALUES(".$this->db->escape($ISBN).",".$this->db->escape($shopid).",".$this->db->escape($storagenumber).")";

		return $this->db->query($sql);
	}

	public function editPurchase($cid,$ISBN,$shopid,$newnumber) {
		$sql = "call purchaseProc(".$this->db->escape($newnumber).",".$this->db->escape($ISBN).",".$this->db->escape($shopid).",".$this->db->escape($cid).");";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delAuthor($IDcardnumber) {
		$sql = "delimiter $$
		start transaction;
		delete from Storage where ISBN = any(select ISBN from Books where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		delete from StockIn where ISBN = any(select ISBN from Books where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		delete from Purchase where ISBN = any(select ISBN from Books where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		delete from Focus where ISBN = any(select ISBN from Books where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		delete from Books where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		delete from Author where IDcardnumber = ".$this->db->escape($IDcardnumber).";
		commit;
		end$$
		delimiter ;";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function findBook($ISBN) {
		$sql = "select * from BookView where ISBN = ".$this->db->escape($ISBN);

		return $this->db->query($sql);
	}
}