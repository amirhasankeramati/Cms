<?php
if($_SERVER['REQUEST_URI'] == '/me/controller/param.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

class param
{
	
	
	
	
	
	public function __construct()
	{
		include_once("database.php");
		$this->db = new database();
	}
	
	
	
	
	
	
	
	public function formEditPost($idpost)
	{
		foreach ($this->db->query("SELECT * FROM ". TABLEPOST ." WHERE id = " . $idpost ."") as $checkpost){
		echo  "<form action='' method='post'>
		<input type='text' id='idPost' name='idPost' style='display:none' value='" . $checkpost['id']  ."'>
		<font color='black'><img src='" .  ADDRESS . "/" . $checkpost['picture'] . "' style='width:40px;height:40px;border-radius:50px;float:right'> - تصویر مطلب</font>
		<input type='text' id='picturePost' name='picturePost' value='" . $checkpost['picture']  ."'>
		<font color='black'><i class='fa fa-edit' style='color:red;font-size:18px'> </i> - عنوان مطلب </font>
		<input type='text' id='titlePost' name='titlePost' value='" . $checkpost['title']  ."'>
		<font color='black'>- پیش مطلب</font>
		<textarea name='contentPost' id='contentPost'>" . $checkpost['post']  ."</textarea>
		<font color='black'>- ادامه مطلب</font>
		<textarea name='morePost' id='morePost'>" . $checkpost['more']  ."</textarea>
		<input type='submit' value='ویرایش شود.' name='editPost' id='editPost'>";
		}
	}
	
	
	
	public function paramDef()
	{
		$this->prmDf = "
		<div class='title-post'> " .  $this->checkpost['title']  . " </div>
<div class='timedate'>
<img src='" . ADDRESS . "/" . $this->checkpost['picture'] . "' width='100px' height='100px' style='border-radius:50px'><br>
<i class='fa fa-calendar' style='font-size:18px;color:green'></i><i class='time'>" . jdate('j F Y', $this->checkpost['time']) . "</i><br>
<i class='fa fa-clock-o' style='color:orange;font-size:18px'> </i><i class='time'>" . jdate('H:i', $this->checkpost['clock'])  . "</i><br>
<i class='fa fa-pencil' style='color:black;font-size:18px'> </i><i class='time'>" . $this->checkpost['auther'] . "</i><br>
<i class='fa fa-comment' style='color:blue;font-size:18px'> </i><i class='time'>نظرات</i><br>
		";
		return $this->prmDf;
	}
	
	
	
	public function paramShowPost()
	{
		foreach ($this->db->query("SELECT * FROM " . TABLEPOST . " ORDER BY id DESC") as $checkpost){
		$this->checkpost = $checkpost;
		$this->paramDef();
			echo /** @lang text */
$this->prmDf . "<i class='fa fa-link' style='color:red;font-size:18px'> </i><i class='time'><a href='" . ADDRESS . "/?post=" . $checkpost['id'] ."'>لینک</a></i></div>
<div class='text-post'>
" . substr(nl2br($checkpost['post']),0,1000) . "
</div>
<div class='both'></div>
<br>";	
			}		
	}
	
	
	
	
	public function paramShowMorePost($idPost,$checkadmin)
	{	
		foreach ($this->db->query("SELECT * FROM " . TABLEPOST . " WHERE id = '" . $idPost ."'") as $checkpost){			
		$this->checkpost = $checkpost;
		$this->paramDef();
				echo /** @lang text */
$this->prmDf . (($checkadmin == 1)? "<i class='fa fa-remove' style='color:red;font-size:18px'> </i><i class='time'><a href='" . ADDRESS . "/admin/panel/?postManager=delete&postId=" . $checkpost['id'] . "'>حذف</a></i><br>
<i class='fa fa-edit' style='color:red;font-size:18px'> </i><i class='time'><a href='" . ADDRESS . "/admin/panel/?postManager=edit&postId=" . $checkpost['id'] . "'>ویرایش</a></i>
":"") . "
</div>
<div class='text-more-post'>
" . substr(nl2br($checkpost['post']),0,4000) . "<br>" . substr(nl2br($checkpost['more']),0,4000) . "
</div>
<div class='both'></div>
<br>";
		}	
	}
	
	
	
	
	
	
	
	
	
}





?>