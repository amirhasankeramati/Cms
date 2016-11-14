<?php
include_once("class.php");
$connect=new Login();
$connect->User();
if(isset($_GET['namepage']))
{
$page=$_GET['namepage'];
$connect->page($page);
$namePage=$connect->namePage;
	   $filer = fopen( "$namePage", "r" ) or header ("location: panel.php") ;

}
if(isset($_GET['out']))
{
	$connect->logout();
	header ("location: index.html");
}
if(isset($_POST['edit']))
{
	if($_POST['security'] == "44651812")
	{
		
	
	$filew = fopen( "$namePage", "w+" ) or exit ( "Unable to open file!" ) ;
	$edit=$_POST['text'];
   fwrite($filew,$edit);
    fclose( $filew ) ;
	}
	else
	{
		echo "<script>alert('خطا !');</script>";
	}
}
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
<input type="button" value="ویرایش" onclick="window.open('panel.php?namepage=menus/menu.html','_self')">
</div>
<br>
<div class="right-box" style="color:black;text-align:left;">
<?php include("menus/project.html"); ?>
<input type="button" value="ویرایش" onclick="window.open('panel.php?namepage=menus/project.html','_self')">
</div>


</div>

<div id="left">

<div class="left-box">
<div class="title"><i class="fa fa-key" style="font-size:38px;color:green"></i>پنل مدیریت
 - <?php echo $_SESSION['username']; ?>  - <a href="panel.php?out=">خروج</a> 
 <br>

 <?php
 if(isset($_GET['namepage']))
 {
	 echo "<div style='text-align:left'>". $namePage ."</div>";
  echo "<form action='' method='post'><textarea rows='50' cols='94' style='text-align:left;direction:ltr' id='text' name='text'>";
  while ( !feof ( $filer ) )
    {
      echo fgets ( $filer );
    }
	echo "</textarea><input type='text' name='security' id='security' placeholder='کلمه امنیتی جهت ویرایش فایل را وارد کنید.'><input type='submit' name='edit' id='edit' value='ویرایش'></form>";
  fclose( $filer ) ;
 }
 ?>
</div>


</div>



</div>
</div>


</body>