<?php
namespace Backend\Controllers;

class LoginController extends \Phalcon\Mvc\Controller
{
	public function indexAction()
	{
		echo "this : <br>";
		print_r(get_class_methods($this->di->get('url')));
		echo "<br>";
		echo "<br>baseUri : ".print_r($this->di->get('url')->getBaseUri());
    echo "<br>login controller index action ....";
	}
}

?>
