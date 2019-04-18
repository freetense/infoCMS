<?php
namespace components;
class Router
{
	private $routes;
	private $rutesArr = array();
	public function __construct()
	{
		$rotersPath = ROOT.'/config/routes.php';
		$this->routes = include($rotersPath);				
	}
	private function getRoutes()
	{
		$rotersValues =  include(ROOT.'/config/routes_values.php');
		foreach ($this->routes as $key => $value) {
			$start = 0;
			$i = 1;
			$stack = array();
			for ($s = true;$s == true;)
			{
				$teg = stripos($key, "<", $start);
				$prefix = stripos($key, ":", $teg);
				if($prefix != false)
				{
					$pos = $prefix-$teg-1;
					$index = substr($key, $teg+1, $pos);
					array_push($stack, $index);
					$start = $prefix;
					$key = str_replace($index.":", "", $key);
					$value = str_replace('<'.$index.'>', '$'.$i, $value);
					$i++;
				}else{ 
					$s = false; 
				}
			}
			$val_true = true;
			foreach ($rotersValues as $keys => $path) {
				if(strstr($key, $keys)) {
					$paths = str_replace($keys,$path,$key);
	             	$this->rutesArr[$paths] = $value;
	             	$val_true = false;
	         	}
		    }
		    if($val_true){
				$this->rutesArr[$key] = $value;
		    }
		}
	}
	private function getURI()
	{
		if(!empty($_SERVER['REQUEST_URI']))
		{
			return trim($_SERVER['REQUEST_URI'], '/');
		}		
	}
	public function run()
	{
		$uri = $this->getURI();

		$this->getRoutes();
		foreach ($this->rutesArr as $uriPattern => $path) {
		   $iTrue = preg_match("~$uriPattern~", $uri);
			if ($iTrue) 
			{	
			    //$internalRoute = $this->getURI();
			    
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				//var_dump($internalRoute);
			
				$segments = explode('/', $internalRoute);		
				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);
				$actionName = 'action'.ucfirst(array_shift($segments));
				$parameters = $segments;
				$controllerFile = ROOT . '/controllers/' .
				$controllerName . '.php';
				$controllerAdmin = ROOT . '/adminPanel/controllers/' .
				$controllerName . '.php';
				if(file_exists($controllerFile))
				{
					include_once($controllerFile);
				}
				if(file_exists($controllerAdmin))
				{
					include_once($controllerAdmin);
				}
				$controllerObject = new $controllerName;
				$result = null;

				if(method_exists(new $controllerObject,$actionName)){
					$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
					echo $result;
			    }
				if($result != null)
				{
					break;
				}
			}
		}
	}

}
