<?php
if($_SERVER['REQUEST_URI'] == '/me/controller/cont.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
// contoroll address

class controller
{
	protected $address;
	protected $arrayAddress;
	protected $urlSite;
	protected $addressPost;
	
	public function __construct()
	{
		            define('ADDRESS' , '/me');
					define('NOT_FOUND',' ' . ADDRESS  . '/404.html');
	}
	
	public function checkAddress()
	{	
		$address = array
		(
		"" . ADDRESS . "/",
		"" . ADDRESS . "/?action=admin",
		"" . ADDRESS . "/admin/login/",
		"" . ADDRESS . "/admin/login/?action=error",
		"" . ADDRESS . "/admin/panel/?action=success",
		"" . ADDRESS . "/admin/panel/?action=error",
		"" . ADDRESS . "/admin/panel/?post=form",
		"" . ADDRESS . "/admin/panel/?namepage=menus/menu.html",
		"" . ADDRESS . "/admin/panel/?namepage=menus/project.html",
		"" . ADDRESS . "/admin/panel/?manager=disabledPosts",
		"" . ADDRESS . "/admin/panel/?manager=enabledPosts",
		"" . ADDRESS . "/admin/panel/?out=logout",
		"" . ADDRESS . "/admin/panel/"
		);
		
		$arrayAddress = count($address);
		$urlSite = $_SERVER['REQUEST_URI'];
		
	    for($y = 0 ; $y < 300 ; $y++)
			{
	   for($x = 0 ; $x < $arrayAddress ; $x++)	
		{
			$postNumber = ADDRESS  ."/?post=" . $y;
			$postDelete = ADDRESS  ."/admin/panel/?postManager=delete&postId=" . $y;
			$postEdit = ADDRESS  ."/admin/panel/?postManager=edit&postId=" . $y;
			if($urlSite === $address[$x] OR $urlSite === $postNumber OR $urlSite === $postDelete OR $urlSite === $postEdit)
			{
				include_once("class.php");
				$connectClass = new Amirhasan();
				$this->connectClass = $connectClass;
				return true;
			}
		}
		}
	}	
	
	
	
	
	
	
	
	
	
	
}


?>