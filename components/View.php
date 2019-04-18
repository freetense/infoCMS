<?php
namespace components;
class View {
	public static function run($path = null,$XItemInfoCMS = array(),$admin = false)
	{
		$view = 'views';
		if($admin === true)
		{
			$view = 'adminPanel/views';
		}
		foreach ($XItemInfoCMS as $XItemInfoKey => $XItemInfoValue) {
		$$XItemInfoKey = $XItemInfoValue;
		}
        
     	include(ROOT.'/'.$view.'/'.$path.'.php');
	}
}