<?php
class Login {
private $username="admin";	
private $password="1212";
private $conn;
private $result;
	public function __construct(){
		session_start();
		try
		{
 $this->conn = new PDO("mysql:host=localhost;dbname=me",$this->username,$this->password);
		$this->conn->exec("set names utf8");
		// echo "connect!";
		}
		catch(PDOExepction $e)
		{
			echo $e->getMessage();
		}
		
	}
	public function setLogin($name,$pass){
		$this->name=$name;
		$this->pass=$pass;
		$query="SELECT * FROM users WHERE `name`=:name AND `pass`=:pass";
		$sql=$this->conn->prepare($query);
		$sql->bindParam(":name",$name);
		$sql->bindParam(":pass",$pass);
		$sql->execute();
		$result=$sql->fetchColumn();
		$this->result=$result;
	}
	public function getLogin(){
		$ip=$_SERVER['REMOTE_ADDR'];
		$rslt="0";
		$query="SELECT * FROM log_login WHERE `ip`=:ip AND `result`=:result";
		$sql=$this->conn->prepare($query);
		$sql->bindParam(":ip",$ip);
		$sql->bindParam(":result",$rslt);
		$sql->execute();
		$count=$sql->fetchColumn();
		if($this->result == "0" AND $count == "0")
		{
			header("location: nimda.php?action=error");
			$ins="INSERT INTO log_login (ip,result,ban)VALUES('$ip','0','1')";
			$this->conn->exec($ins);
		}
		elseif($count > "2")
		{
			header("location: nimda.php?action=error");
		}
		else
		{
			$ins="INSERT INTO log_login (ip,result,ban)VALUES('$ip','1','0')";
			$this->conn->exec($ins);
			$_SESSION['username']=$this->name;
			// echo "ok !!!";
			header ("location: panel.php");
		}
		
		
	}
	
	public function logout()
	{
		session_unset();
		header ("location: index.php");
	}
	public function User()
	{
		if($_SESSION['username'] == "")
		{
			header ("location: index.html");
		}
	}
	public function nimda()
	{
		if(isset($_SESSION['username']))
		{
			header ("location: panel.php");
		}
	}
	public function Page($namePage) {
		$this->namePage=filter_var($namePage,FILTER_SANITIZE_MAGIC_QUOTES);
		$this->namePage=filter_var($namePage,FILTER_SANITIZE_STRING);
		$filterPage=array
		(
		"class.php",
		"panel.php",
		"nimda.php"
		);
		$arraylength=count($filterPage);
		for($x=0;$x < $arraylength; $x++)
		{
			if($this->namePage == $filterPage[$x])
		{
			header ("location: panel.php?action=error");
		}
		else
		{
				   $filer = fopen($this->namePage,"r") or header ("location: panel.php?action=error") ;
				   $this->filer = $filer;
		}
		
		}
	}
	public function editpage($page)
	{
		if($_POST['security'] == "44651812")
	{
	$filew = fopen( "$this->namePage", "w+" ) or exit ( "Unable to open file!" ) ;
	$edit=$_POST['text'];
   fwrite($filew,$edit);
    fclose( $filew ) ;
		header ("location: panel.php?action=success");
	}
	else
	{
		header ("location: panel.php?action=error");
	}
	}
	public function actions($action)
	{
		$this->action=$action;
		if($this->action == 'error')
		{
			echo'<script>
		document.getElementById("errors").style.display="block";
	</script>';
		}
		elseif($this->action == 'success')
		{
			echo'<script>
		document.getElementById("success").style.display="block";
	</script>';
		}
		else
		{
			echo'<script>
		document.getElementById("info").style.display="block";
	</script>';
		}
	}
	
	
	
}
?>
	