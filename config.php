<?php 
if($_SERVER['REQUEST_URI'] == '/me/config.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
// Start name pages ...
			
		define('TITLE' , 'وب سایت شخصی');
		define('NAME','امیرحسن');
		define('FAMILY','کرامتی');
		define('COUNTRY','ایران');
		define('BIRTHDAY','73/12/28');
		define('EMAIL','amirh1749@gmail.com');
		define('ALBUM','آلبوم تصاویر');
		define('STYLE','/me/style.css');
		define('SCRIPT','/me/script/script.js');
		define('JQUERY','/me/script/jquery.js');
		define('TITLELOGIN','ورود به پنل');
		define('TABLEPOST','posts');
//End name pages ...
?>
