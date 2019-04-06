<?php
class AdminsController
{
	public function actionIndex()
	{
		$newsList = array();
		$newsList = Admins::run();
		$twig  = Twig::connect(false);
		print_r($newsList);
		echo $twig->render('news/index.php', array('data' => $newsList));
		return true;
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