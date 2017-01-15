<?php
include_once("controller/cont.php");
$connect=new controller();
($connect->checkAddress() == true) ?  : header("location:  " . NOT_FOUND . "");
$connect->connectClass->User();
if($connect->connectClass->checkadmin() == true)
{
	if(isset($_POST['editPost']))
	{
		$idpost = $_POST['idPost'];
		$titlePost = $_POST['titlePost'];
		$contentPost  = $_POST['contentPost'];
		$morePost = $_POST['morePost'];
		$picturePost = $_POST['picturePost'];
		if($picturePost == '')
	{
		$picturePost = 'images/1.png';
	}
		$connect->connectClass->upPost($titlePost,$contentPost,$picturePost,$morePost,$idpost);
	}
	if(isset($_GET['namepage']))
{
$page=$_GET['namepage'];
$connect->connectClass->page($page);
}	
if(isset($_GET['out']))
{
	$connect->connectClass->logout();
}
if(isset($_POST['edit']))
{
	$connect->connectClass->editpage();
}
if(isset($_GET['manager']))
{
	$connect->connectClass->manager();
}
if(isset($_GET['change']))
{
	$address = $_GET['change'];
	$connect->connectClass->change($address);
}
if(isset($_POST['sendPost']))
{
	$title=$_POST['title'];
	$content=$_POST['content'];
	$more=$_POST['more'];
	$picturePost = $_POST['picturePost'];
	if($picturePost == '')
	{
		$picturePost = 'images/1.png';
	}
	$connect->connectClass->sendPost($picturePost,$title,$content,$more);
}
?>

<!Doctype html>
<html>
<head>
<title><?php echo TITLE; ?></title>
<meta charset="UTF-8">
<link rel="stylesheet" href="<?php echo STYLE; ?>">
<script src="<?php echo JQUERY; ?>"></script>
<script src="<?php echo SCRIPT; ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>

<div id="box-setting">
<div id="right">

<div class="right-box">
<?php 
include("menus/menu.html");
$connect->connectClass->editadmin("ارسال مطلب", ADDRESS . "/admin/panel/?post=form");
$connect->connectClass->editadmin("ویرایش این قسمت", ADDRESS . "/admin/panel/?namepage=menus/menu.html");
$connect->connectClass->editadmin($_SESSION['username'] . "، خروج از پنل", ADDRESS . "/admin/panel/?out=logout");
 ?>
</div>
<br>
<div class="right-box" style="color:black;text-align:left;">
<?php include("menus/project.html"); 
$connect->connectClass->editadmin("ویرایش این قسمت", ADDRESS . "/admin/panel/?namepage=menus/project.html");
?>
</div>


</div>

<div id="left">
<div class="title">
<div class="left-box">
<div class="error-class danger" id="errors"></div>
<div class="error-class success" id="success"></div>
<div class="error-class info" id="info"></div>


<?php
$connect->connectClass->getAction();
 if(isset($_GET['namepage']))
 {
	 echo "<div style='text-align:left'>". $connect->connectClass->namePager ."</div><hr color='#f1f1f1'>";
  echo "<form action='' method='post'><textarea style='text-align:left;direction:ltr' id='text' name='text'>";
  while ( !feof ( $connect->connectClass->filer ) )
    {
      echo fgets ( $connect->connectClass->filer );
    }
	echo "</textarea><hr color='#f1f1f1'><input type='text' name='security' id='security' placeholder='کلمه امنیتی جهت ویرایش فایل را وارد کنید.'><input type='submit' name='edit' id='edit' value='ویرایش'></form>";
  fclose( $connect->connectClass->filer ) ;
 }
 if(isset($_GET['post']))
{
	
	if($_GET['post'] == 'form')
	{
		?>
		
		<form action="" method="post">
		<input type="text" name="picturePost" id="picturePost" style="text-align:left;direction:ltr;" placeholder="Url picture... example : images/1.png">
		<input type="text" name="title" id="title" style="border:0px;border-left:5px solid silver;" placeholder="عنوان ...">
		<textarea name="content" id="content" placeholder="مطلب ..."></textarea>
		<textarea name="more" id="more" placeholder="ادامه مطلب ..."></textarea>
		<input type="submit" name="sendPost" id="sendPost" value="ارسال">
		</form>

		<?php
	}
}
if(isset($_GET['postManager']))
{
	$idpost = $_GET['postId'];
	if($_GET['postManager'] == 'delete')
	{
		$connect->connectClass->delete_post($idpost);
	}
	elseif($_GET['postManager'] == 'edit')
	{
		$connect->connectClass->editpost($idpost);
	}
	else
	{
		return false;
	}
}
 ?>
</div>


</div>



</div>
</div>


</body>
<?php
}
?>