<?php
include_once("controller/cont.php");
$connect=new controller();
($connect->checkAddress() == true) ?  : header("location:  " . NOT_FOUND . "");
$connect->connectClass->nimda();
$connect->connectClass->repatch();
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
	$repatch = $_POST['repatch'];
	if($repatch == $connect->connectClass->getRnd AND $user != '' AND $pass != '')
	{
	$connect->connectClass->setLogin($user,$pass);
	$connect->connectClass->getLogin();
	}
	else
	{
		echo "کلمه امنیتی را اشتباه وارد کرده اید.";
	}
}
?>

<div class="title"><i class="fa fa-key" style="font-size:38px;color:green"></i><?php echo TITLE . " / " . TITLELOGIN; ?></div>
<div class="error-class danger" id="errors"></div>
<div class="error-class success" id="success"></div>
<div class="error-class info" id="info"></div>
<?php
$connect->connectClass->getAction();
?>
<form action="<?php echo htmlspecialchars(ADDRESS . "/admin/login/");?>" method="post">
<input type="text" name="username" id="username" placeholder="نام کاربری">
<input type="password" name="pass" id="pass" placeholder="پسورد">
<input type="text" name="repatch" id="repatch" placeholder="کد رو به رو را وارد کنید : <?php echo $connect->connectClass->getRnd; ?>">
<button type="submit" class="button" name="submit"><span>ورود</span></button>


</form>

</div>



</div>
</div>


</body>