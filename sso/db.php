<?php
class SSOdb 
{
	private $servername = 'localhost';
	private $username 	= 'bps3300_user1';
	private $password 	= 'cp4neljatengoke3300';
	private $database	= 'bps3300_3vit4jaten4';
	private $table		= 'sso_session';
	private $cn;
	private $connected = false;

	function __construct ()
	{
		$this->cn = new mysqli($this->servername, $this->username, $this->password, $this->database);

		if (!$cn->connect_error) {
	  		$connected = true;
		}
	}

	public function insert($data = array())
	{
		if($data){
			$sql = "insert into ".$this->table." (".implode(',', array_keys($data)).") values ('".implode("', '", array_values($data))."')";

			return $this->cn->query($sql);
			//return $sql;
		}
	}

	public function select($where = array())
	{
		if($where){
			$arr = array();
			foreach($where as $key=>$value){
				$arr[] = $key."='".$value."'";
			}

			$sql = "select * from ".$this->table." where ".implode(' and ', $arr)." order by ".implode(', ', array_keys($where));

			$result = $this->cn->query($sql)->fetch_assoc();

			unset($result['id']);
			return $result;
		}
	}
}

/*$db = new SSOdb;
$db->insert(array('username'=>'puguh.raharjo','nama'=>'Puguh Raharjo'));
print_r($db->select(array('username'=>'puguh.raharjo')));*/