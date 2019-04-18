<?php
use adminPanel\models\Admin;
use components\Twig;
use components\View;
use components\Pagination;
class AdminController
{
	public function actionIndex()
	{
		$newsList = array();
		$newsList = Admin::run();
		$twig  = Twig::connect(true);
		print_r($newsList);
		return $twig->render('news/index.php', array('data' => $newsList));
	}
	public function actionView($id)
	{
		if($id)
		{
			$newsItem = Admin::runId($id);
			$pagination = new Pagination(4, $id, 1,'');
			$pagination = $pagination->get();
			return Twig::connect(true)->render('news/view.php', array('data' => $pagination, 'key' => $newsItem));
		}
	}
}