<?php
class Twig {

	public static function connect($admin = false)
	{
		$view = 'views';
		if($admin === true)
			$view = 'adminPanel/views';

     	$loader = new Twig_Loader_Filesystem(ROOT.'/'.$view.'/');
		$twig = new Twig_Environment($loader);
		return $twig;
	}
}