<?php
namespace models;
use components\inClass\XInfoSelect;
use components\inClass\XInfoInsert;
use components\inClass\XInfoUpdate;
class Admins
{
	public static function run(){
		$ar = array('id:count','title');
		$Select = XInfoSelect::connect();
		$arra = array(
			array(null,'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1','erterte1','terter3','ertert4'),
			array(null,'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1','erterte1','terter3','ertert4')
		);
		$arra1 = array('id', 'title', 'date', 'short_content', 'content', 'autor_name', 'type', 'preview');
        //XInfoInsert::connect()->sql('news',$arra)->run();
		$arra2 = array("title", "short_content", "date");

		//$info1 = $Select->sql('news1',$arra2)->query();
		//Insert::connect()->select('news', $info1,$arra2)->run();
		//$ar1 = array('news.title'=>"green1",'news.title'=>"green1");
		//$ar2 = array('news.date' => 345345435, 'news.date:OR' => 345345435);
		//array('title:<='=>"green", 'date:OR:>'=>"green");
        //echo Update::connect()->join("news1",array("news.date" => "news1.date"))->sql('news',$ar1)->where($ar2)->run();
        //->where($ar2)->orderBy(['id:DESC'])->limit(3)->query();

		 return $Select->sql('news',array("title"))//->union()->sql('news',array("id"))
		//->join("user:left",array("user.id" => "news.id1"))
		//->join("user:RIGHT",array("id" => "id1"))
		//->underWhere(array("news.id" => 1))
		//->orderBy(['title'])
		//->limit(2)
		//->offset(0)
		->run();


	}
	public static function runId($id)
	{
		$ar = array('id' => $id);
		return XinfoSelect::connect()->sql('news',array("title"))
							 ->where($ar)
							 ->run();

	}
}