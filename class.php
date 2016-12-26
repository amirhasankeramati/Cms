<?php
if($_SERVER['REQUEST_URI'] == '/me/class.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

// Start login class ...
/**
 * @property mixed namePager
 * @property resource filer
 * @property mixed action
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
		include_once("database.php");
		$this->db = new database();
		session_start();
		
		
	}
	public function setLogin($name,$pass){
		$this->name=$name;
		$this->pass=$pass;
		$query= /** @lang sql */ 'SELECT * FROM users WHERE `name`=:name AND `pass`=:pass';
		$sql=$this->db->conn->prepare($query);
		$sql->bindParam(":name",$name);
		$sql->bindParam(":pass",$pass);
		$sql->execute();
		$result=$sql->fetchColumn();
		$this->result=$result;
	}
	public function getLogin(){
		$ip=$_SERVER['REMOTE_ADDR'];
		$rslt="0";
		$query= /** @lang sql */ "SELECT * FROM log_login WHERE `ip`=:ip AND `result`=:result";
		$sql=$this->db->conn->prepare($query);
		$sql->bindParam(":ip",$ip);
		$sql->bindParam(":result",$rslt);
		$sql->execute();
		/** @var number $count */
		$count=$sql->rowCount();
		if($this->result == "0")
		{
			header("location: ?action=error");
			$ins= /** @lang sql */ "INSERT INTO log_login (ip,result,ban)VALUES('$ip','0','1')";
			$this->db->conn->exec($ins);
		}
		elseif($count > '5')
		{
			header("location: ?action=error");
		}
		else
		{
			$ins= /** @lang sql */ "INSERT INTO log_login (ip,result,ban)VALUES('$ip','1','0')";
			$this->db->conn->exec($ins);
			$_SESSION['username'] = $this->name;
			$_SESSION['login_in'] = true;
			// echo "ok !!!";
			header ("location: /me/?action=admin");
		}
		
		
	}
	
	public function logout()
	{
		if($_GET['out'] == 'logout')
		{
		session_unset("username");
		$_SESSION['login_in'] = false;
		header ("location: /me");
		}
	}
	public function User()
	{
				if($_SESSION['login_in'] == false)
		{
			header ("location: /me");
		}
	}
	public function nimda()
	{
		if(isset($_SESSION['username']))
		{
			header ("location: /me/admin/panel/");
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
		$managersql=$this->db->conn->prepare($manager);
		$managersql->execute();	
		$checkmanager = $managersql->fetch(PDO::FETCH_ASSOC);
		$this->checkmanager=$checkmanager;

		
		if($resultManager == 'showButton')
		{
			
		if($checkmanager['posts'] == '0')
		{
			echo $this->editadmin('نمایش پست ها غیرفعال شود.','/me/admin/panel/?manager=disabledPosts');
		}
		elseif($checkmanager['posts'] == '1')
		{
			echo $this->editadmin('نمایش پست ها فعال شود.','/me/admin/panel/?manager=enabledPosts');

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
			$sqlposts=$this->db->conn->prepare($queryposts);
			$sqlposts->bindParam(":posts",$disabledPosts);
			$sqlposts->execute();
			header("location: /me");
		}
		elseif($_GET['manager'] == 'enabledPosts')
		{
			$enabledPosts=0;
			$queryposts= /** @lang sql */ "UPDATE manager SET posts=:posts";
			$sqlposts=$this->db->conn->prepare($queryposts);
			$sqlposts->bindParam(":posts",$enabledPosts);
			$sqlposts->execute();
		header("location: /me");

		}
		else
		{
		header("location: /me/admin/panel/?action=error");

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

		foreach ($this->db->query("SELECT * FROM " . TABLEPOST . " ORDER BY id DESC") as $checkpost){

			echo /** @lang text */
"
<div class='title-post'> " .  $checkpost['title']  . " </div>
<div class='timedate'>
<img src='http://localhost:60/me/images/me.jpg' width='100px' height='100px' style='border-radius:50px'><br>
<i class='fa fa-calendar' style='font-size:18px;color:green'></i><i class='time'>" . jdate('j F Y', $checkpost['time']) . "</i><br>
<i class='fa fa-clock-o' style='color:orange;font-size:18px'> </i><i class='time'>" . $checkpost['clock'] . "</i><br>
<i class='fa fa-pencil' style='color:black;font-size:18px'> </i><i class='time'>" . $checkpost['auther'] . "</i><br>
<i class='fa fa-comment' style='color:blue;font-size:18px'> </i><i class='time'>نظرات</i><br>
<i class='fa fa-link' style='color:red;font-size:18px'> </i><i class='time'><a href='/me/?post=" . $checkpost['id'] ."' style='color:silver'>لینک</a></i></div>
<div class='text-post'>
" . substr(nl2br($checkpost['post']),0,1000) . "
</div>
<div class='both'></div>
<br>";

			}
			}
			else
			{
		foreach ($this->db->query("SELECT * FROM " . TABLEPOST . " WHERE id = '" . $idPost ."'") as $checkpostmore){			
			if($this->checkadmin() == true)
			{
				echo /** @lang text */
"
<div class='title-post'> " .  $checkpostmore['title']  . " </div>
<div class='timedate'>
<i class='fa fa-calendar' style='font-size:18px;color:green'></i><i class='time'>" . jdate('j F Y', $checkpostmore['time']) . "</i><br>
<i class='fa fa-clock-o' style='color:orange;font-size:18px'> </i><i class='time'>" . $checkpostmore['clock'] . "</i><br>
<i class='fa fa-pencil' style='color:black;font-size:18px'> </i><i class='time'>" . $checkpostmore['auther'] . "</i><br>
<i class='fa fa-comment' style='color:blue;font-size:18px'> </i><i class='time'>نظرات</i><br>
<i class='fa fa-remove' style='color:red;font-size:18px'> </i><i class='time'><a href='/me/admin/panel/?postManager=delete&postId=" . $checkpostmore['id'] . "'>حذف</a></i><br>
<i class='fa fa-edit' style='color:red;font-size:18px'> </i><i class='time'><a href='/me/admin/panel/?postManager=edit&postId=" . $checkpostmore['id'] . "'>ویرایش</a></i>
</div>
<div class='text-post'>
" . substr(nl2br($checkpostmore['post']),0,4000) . "<br>" . substr(nl2br($checkpostmore['more']),0,4000) . "
</div>
<div class='both'></div>
<br>";
			}
			else
			{
			echo /** @lang text */
"
<div class='title-post'> " .  $checkpostmore['title']  . " </div>
<div class='timedate'>
<i class='fa fa-calendar' style='font-size:18px;color:green'></i><i class='time'>" . jdate('j F Y', $checkpostmore['time']) . "</i><br>
<i class='fa fa-clock-o' style='color:orange;font-size:18px'> </i><i class='time'>" . $checkpostmore['clock'] . "</i><br>
<i class='fa fa-pencil' style='color:black;font-size:18px'> </i><i class='time'>" . $checkpostmore['auther'] . "</i><br>
<i class='fa fa-comment' style='color:blue;font-size:18px'> </i><i class='time'>نظرات</i><br>
</div>
<div class='text-post'>
" . substr(nl2br($checkpostmore['post']),0,4000) . "<br>" . substr(nl2br($checkpostmore['more']),0,4000) . "
</div>
<div class='both'></div>
<br>";
			}
		
		
		}
		
		
			}
			
		
		
		}
		else
		{
			echo 'ErRoR...';
		}
			
			
	
	}
	
	public function editPost($idPost)
	{
		foreach ($this->db->query("SELECT * FROM " . TABLEPOST . " WHERE id = '" . $idPost ."'") as $checkpost){
				

echo "
	<form action='' method='post'>
		<input type='text' id='idPost' name='idPost' style='display:none' value='" . $checkpost['id']  ."'>
		<font color='silver'>- عنوان مطلب </font>
		<input type='text' id='titlePost' name='titlePost' value='" . $checkpost['title']  ."'>
		<font color='silver'>- پیش مطلب</font>
		<textarea name='contentPost' id='contentPost'>" . $checkpost['post']  ."</textarea>
		<font color='silver'>- ادامه مطلب</font>
		<textarea name='morePost' id='morePost'>" . $checkpost['more']  ."</textarea>
		<input type='submit' value='ویرایش شود.' name='editPost' id='editPost'>
";

				
				}
	}
	
	public function upPost($titlePost,$contentPost,$morePost,$idpost)
	{
		$values = array(
		'title' => $titlePost,
		'post'  => $contentPost,
		'more'  => $morePost
		);
		$value = array(
		'id'   => $idpost
		);
		$this->db->where($value);
		$this->db->update(TABLEPOST,$values);
	}
	
	public function sendPost($title,$content,$more,$time)
	{
		$values =array(
		'title' => $title,
		'post'  => $content,
		'more'  => $more,
		'time'  => $time
		);
		$this->db->insert(TABLEPOST,$values);
		
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
		$this->db->where($where);
		$this->db->delete(TABLEPOST);
	
	}	
}

?>
	