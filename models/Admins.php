<?php
namespace models;
use components\inClass\XInfoSelect;
use components\inClass\XInfoInsert;
use components\inClass\XInfoUpdate;
class Admins
{
	public static function run(){
		$ar = array('id:count','title');
		$arra = array(
			array(null,'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1','erterte1','terter3','ertert4'),
			array(null,'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1','erterte1','terter3','ertert4')
		);
		$arra1 = array('id', 'title', 'date', 'short_content', 'content', 'autor_name', 'type', 'preview');
        XInfoInsert::connect()->sql('news',$arra,$arra1)->query();
		$arra2 = array("title", "short_content", "date");

		$info1 = XinfoSelect::connect()->sql('news1',$arra2)->query();
		echo XinfoInsert::connect()->select('news', $info1,$arra2)->query();
		$ar1 = array('news.title'=>"green1",'news.title'=>"green1");
		$ar2 = array('news.date' => 345345435, 'news.date:>:OR' => 345345435);
		//array('title:<='=>"green", 'date:OR:>'=>"green");
        echo XinfoUpdate::connect() ->sql('news',$ar1)->join("news1",array("news.date:>:AND" => "news1.date","news.date" => "news1.date"))

            ->underWhere($ar2)
            //->run();
        //->where($ar2)->orderBy(['id:DESC'])->limit(3)
            ->query();


       // echo XinfoSelect::connect()->sql('news')
           // ->join("user:left",array("user.id:AND" => "20","user.title:AND" => "news.title"))
            //->join("user:RIGHT",array("id" => "id1"))
            // ->underWhere(array("news.id" => 1))
          //   ->orderBy(['id:ASC'])
            //->limit(2)
            //->offset(0)
           // ->query();



	}
	public static function runId($id)
	{
		$ar = array('id' => $id);
		return XinfoSelect::connect()->sql('news',array("title"))
							 ->where($ar)
							 ->run();

	}
}