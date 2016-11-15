<?php
include("class.php");
$connect=new Login();
$connect->nimda();
?>
<!Doctype html>
<html>
<head>
<title>وب سایت شخصی</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>

<div id="box-setting">
<div id="right">

<div class="right-box">
<?php include("menus/menu.html"); ?>
</div>
<br>
<div class="right-box" style="color:black;text-align:left;">
<?php include("menus/project.html"); ?>
</div>


</div>

<div id="left">

<div class="left-box">
<?php
if(isset($_POST['username']))
{
	$user=$_POST['username'];
	$pass=$_POST['pass'];
	$connect->setLogin($user,$pass);
	$connect->getLogin();
}
?>

<div class="title"><i class="fa fa-key" style="font-size:38px;color:green"></i> ورود به پنل</div>
<div class="error-class danger" id="errors"></div>
<div class="error-class success" id="success"></div>
<div class="error-class info" id="info"></div>
<?php
if(isset($_GET['action']))
{
	$action=$_GET['action'];
$connect->actions($action);
}
?>
<form action="" method="post">
<input type="text" name="username" id="username" placeholder="نام کاربری">
<input type="password" name="pass" id="pass" placeholder="پسورد">
<input type="submit" name="submit" value="ورود">


</form>

</div>



</div>
</div>


</body>