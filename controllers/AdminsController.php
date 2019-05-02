<?php
use models\Admins;
use components\Twig;
use components\View;
use components\Pagination;
class AdminsController
{
	public function actionIndex()
	{
		$newsList = array();
		$newsList = Admins::run();
		$twig  = Twig::connect(false);
		//print_r($newsList);
		return View::run('news/index',  array('keys' => $newsList));
		
	}
	public function actionView($id)
	{
		if($id)
		{
			$newsItem = Admins::runId($id);
			$pagination = new Pagination(4, $id, 1,'');
			$pagination = $pagination->get();
			echo Twig::connect(false)->render('news/view.php', array('data' => $pagination, 'key' => $newsItem));
		}
		return true;
	}
}