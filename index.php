<?php
include_once("controller/cont.php");
$connect=new controller();
($connect->checkAddress() == true) ?  : header("location:  "  .  ADDRESS .  NOT_FOUND . "");
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
<body class="background-body">

<div id="box-setting">
<div id="right">

<div class="right-box">
<div class="error-class admin" id="admin">
</div>

<?php 
$connect->connectClass->getAction();
include("menus/menu.html"); 
$connect->connectClass->editadmin("پنل مدیریت","" .  ADDRESS  ."/admin/panel/");
$connect->connectClass->editadmin("ویرایش این قسمت","" .  ADDRESS  ."/admin/panel/?namepage=menus/menu.html");
$connect->connectClass->editadmin("خروج از پنل","" .  ADDRESS  ."/admin/panel/?out=logout");
?>

</div>
<br>
<div class="right-box" style="color:black;text-align:left;">
<?php 
include("menus/project.html"); 
$connect->connectClass->editadmin("ویرایش این قسمت","" .  ADDRESS  ."/admin/panel/?namepage=menus/project.html");
?>

</div>


</div>

<div id="left">

<div class="left-box">
<div class="title"><i class="fa fa-edit" style="font-size:38px;color:green" onclick="window.open('<?php echo ADDRESS; ?>/admin/login/','_self')"></i> <?php echo TITLE; ?></div>
<?php 
$connect->connectClass->getShowPost();
$connect->connectClass->manager('showButton');
 ?>
</div>


</div>
</div>


</body>