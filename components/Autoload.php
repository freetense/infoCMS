<?php
spl_autoload_register(
function ($name)
{
	$array_paths = array
	(   '/components/inClass/',
		'/components/',
		'/models/',
		'/controllers/',
		'/adminPanel/models/',
		'/adminPanel/controllers/'
	);
	foreach ($array_paths as $path)
	{
		$path = ROOT .  $path . $name . '.php';
		if(is_file($path))
		{
    		include_once $path;
		}
	}
},true, true);

require_once (ROOT.'/components/vendor/autoload.php');
require_once(ROOT.'/components/Layouts.php');

