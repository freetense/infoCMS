<?php
class View {
	public static function run($path = null,$admin = false)
	{
		$view = 'views';
		if($admin === true)
		{
			$view = 'adminPanel/views';
		}

     	include(ROOT.'/'.$view.'/'.$path.'.php');
	}
}