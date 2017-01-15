<?php
if($_SERVER['REQUEST_URI'] == '/me/class.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

// Start login class ...
/**
 * @property mixed namePager
 * @property resource filer
 * @property mixed action
 * @property mixed setRand

 */
class Login {
    protected $username="admin";
    protected $password="1212";
    protected $conn;
    protected $result;
    protected $name;
	protected $pass;
	protected $page;
	protected $namePage;

	public function __construct(){
		
		include_once("config.php");
		include_once("jdf.php");
		include_once("controller/param.php");
		$this->param = new param();
		session_start();
		
		
	}
	
	public function repatch()
	{
     if(!isset($_SESSION['recTime'])){
		 
		 $_SESSION['newTime']    = '';
		 $_SESSION['recTime']    = '';
		 $_SESSION['newRepatch'] = 'code...';
	 }
		$getTime = time();	
			if($_SESSION['recTime'] < $getTime)
		{
			$setRnd = rand(100,1000);
			$_SESSION['newTime'] = time();
		    $_SESSION['recTime'] = $_SESSION['newTime'] + 10;
			$_SESSION['newRepatch'] = $setRnd;
			$this->getRnd= $_SESSION['newRepatch'];
			return  $this->getRnd;
		}
		else
		{
			$this->getRnd= $_SESSION['newRepatch'];
			return  $this->getRnd;
		}
	}
	
	public function setLogin($name,$pass){
		$this->name=htmlspecialchars($name);
		$this->pass=htmlspecialchars($pass);
		$query= /** @lang sql */ 'SELECT * FROM users WHERE `name`=:name AND `pass`=:pass';
		$sql=$this->param->db->conn->prepare($query);
		$sql->bindParam(":name",$this->name);
		$sql->bindParam(":pass",$this->pass);
		$sql->execute();
		$result=$sql->fetchColumn();
		$this->result=$result;
		
	}
	public function getLogin(){
		$ip=$_SERVER['REMOTE_ADDR'];
		$rslt=0;
		$query= /** @lang sql */ "SELECT * FROM log_login WHERE `ip`=:ip AND `result`=:result";
		$sql=$this->param->db->conn->prepare($query);
		$sql->bindParam(":ip",$ip);
		$sql->bindParam(":result",$rslt);
		$sql->execute();
		/** @var number $count */
		$count=$sql->rowCount();
		if($this->result == 0)
		{
			header("location: ?action=error");
			$ins= /** @lang sql */ "INSERT INTO log_login (ip,result,ban)VALUES('$ip','0','1')";
			$this->param->db->conn->exec($ins);
		}
		elseif($count > 5)
		{
			header("location: ?action=error");
		}
		else
		{
			$ins= /** @lang sql */ "INSERT INTO log_login (ip,result,ban)VALUES('$ip','1','0')";
			$this->param->db->conn->exec($ins);
			$_SESSION['username'] = $this->name;
			$_SESSION['login_in'] = true;
			// echo "ok !!!";
			header ("location: " . ADDRESS . "/?action=admin");
		}
		
		
	}
	
	public function logout()
	{
		if($_GET['out'] == 'logout')
		{
		session_unset("username");
		$_SESSION['login_in'] = false;
		header ("location: " . ADDRESS);
		}
	}
	public function User()
	{
				if($_SESSION['login_in'] == false)
		{
			header ("location: " . ADDRESS);
		}
	}
	public function nimda()
	{
		if(isset($_SESSION['username']))
		{
			header ("location: " . ADDRESS . "/admin/panel/");
		}
	}
	public function Page($namePage) {
		$this->namePager=filter_var($namePage,FILTER_SANITIZE_MAGIC_QUOTES);
		$this->namePager=filter_var($namePage,FILTER_SANITIZE_STRING);
		$filterPage=array
		(
		"class.php",
		"panel.php",
		"nimda.php",
		".htaccess",
		"font.css",
		"style.css"
		);
		$arraylength=count($filterPage);
		for($x=0;$x < $arraylength; $x++)
		{
			if($this->namePager == $filterPage[$x])
		{
			header ("location: ?action=error");
		}
		else
		{
				   $filer = fopen($this->namePager,"r") or header ("location: ?action=error") ;
				   $this->filer = $filer;
		}
		
		}
	}
	public function editpage()
	{
		if($_POST['security'] == "44651812")
	{
	$filew = fopen( "$this->namePager", "w+" ) or exit ( "Unable to open file!" ) ;
	$edit=$_POST['text'];
   fwrite($filew,$edit);
    fclose( $filew ) ;
		header ("location: ?action=success");
	}
	else
	{
		header ("location: ?action=error");
	}
	}
	public function actions($action)
	{
		$this->action=$action;
		if($this->action == 'error')
		{
			echo /** @lang text */
			'<script>
		document.getElementById("errors").style.display="block";
	</script>';
		}
		elseif($this->action == 'success')
		{
			echo /** @lang text */
			'<script>
		document.getElementById("success").style.display="block";
	</script>';
		}
		elseif($this->action == 'admin')
		{
			echo /** @lang text */
			'<script>
		document.getElementById("admin").style.display="block";
	</script>';
		}
		else
		{
			echo /** @lang text */
			'<script>
		document.getElementById("info").style.display="block";
	</script>';
		}
	}
	
	public function checkadmin()
	{
		if(isset($_SESSION['username']))
		{
			return true;
		}
		else
		{
			return false;
		}
		
		
	}
	
}

// end login class ...



// Start public class ...

/**
 * @property mixed checkmanager
 */
class Amirhasan extends Login
{


	public function manager($resultManager)
	{	
		$manager= /** @lang sql */ "SELECT * FROM manager";
		$managersql=$this->param->db->conn->prepare($manager);
		$managersql->execute();	
		$checkmanager = $managersql->fetch(PDO::FETCH_ASSOC);
		$this->checkmanager=$checkmanager;

		
		if($resultManager == 'showButton')
		{
			
		if($checkmanager['posts'] == '0')
		{
			echo $this->editadmin('نمایش پست ها غیرفعال شود.', ADDRESS . '/admin/panel/?manager=disabledPosts');
		}
		elseif($checkmanager['posts'] == '1')
		{
			echo $this->editadmin('نمایش پست ها فعال شود.', ADDRESS . '/admin/panel/?manager=enabledPosts');

		}
		else
		{
			return false;
		}
		}
		
		if($this->checkadmin() == true)
		{
		if(isset($_GET['manager']))
		{
		if($_GET['manager'] == 'disabledPosts')
		{
			$disabledPosts=1;
			$queryposts= /** @lang sql */ "UPDATE manager SET posts=:posts";
			$sqlposts=$this->param->db->conn->prepare($queryposts);
			$sqlposts->bindParam(":posts",$disabledPosts);
			$sqlposts->execute();
			header("location: /me");
		}
		elseif($_GET['manager'] == 'enabledPosts')
		{
			$enabledPosts=0;
			$queryposts= /** @lang sql */ "UPDATE manager SET posts=:posts";
			$sqlposts=$this->param->db->conn->prepare($queryposts);
			$sqlposts->bindParam(":posts",$enabledPosts);
			$sqlposts->execute();
		header("location: " . ADDRESS);

		}
		else
		{
		header("location: " . ADDRESS . "/admin/panel/?action=error");

		}
		}
	}
	}
		
	public function showpost($idPost)
	{
		$this->manager('');
		if($this->checkmanager['posts'] == '1')
		{
			echo '<div class="public-class info"></div>';
		}
		elseif($this->checkmanager['posts'] == '0')
		{
			if($idPost == '')
			{
			$this->param->paramShowPost();
			}
			else
			{
				
				if($this->checkadmin() == true)
				{
					$this->param->paramShowMorePost($idPost,1);
				}
				else
				{
					$this->param->paramShowMorePost($idPost,0);
				}
	      	}
		}
	}
	
	public function editPost($idPost)
	{	
$this->param->formEditPost($idPost);		
	}
	
	public function upPost($titlePost,$contentPost,$picturePost,$morePost,$idpost)
	{
		$values = array(
		'title'   => $titlePost,
		'post'    => $contentPost,
		'picture' => $picturePost,
		'more'    => $morePost
		);
		$value = array(
		'id'   => $idpost
		);
		$this->param->db->where($value);
		$this->param->db->update(TABLEPOST,$values);
	}
	
	public function sendPost($picturePost,$title,$content,$more)
	{
		$values =array(
		'picture' => $picturePost,
		'title' => $title,
		'post'  => $content,
		'more'  => $more,
		'clock' => time(),
		'time'  => time()
		);
		$this->param->db->insert(TABLEPOST,$values);
		
	}	
	public function editadmin($name,$link)
	{
		if(isset($_SESSION['username']))
		{
		echo /** @lang input */ "<input type='button' value='$name' onclick=window.open('$link','_self')>";
		}
	}
	
	public function delete_post($idpost) {

		$where = array(
			'id' => $idpost
		);
		$this->param->db->where($where);
		$this->param->db->delete(TABLEPOST);
	
	}	
	public function getAction()
	{
		if(isset($_GET['action']))
             {
              $action=$_GET['action'];
              return $this->actions($action);
             }
	}
	public function getShowPost()
	{
		if(isset($_GET['post']))
          {
	     $idpost=$_GET['post'];
         return $this->showpost($idpost);
          }
        else
          {
        return $this->showpost('');
          }
	}
	
	public function change($address)
	{
		$values = array (
		'post_profile' => $address
		);
		$this->param->db->update('manager',$values);
	}
	
	
	
}

?>
	