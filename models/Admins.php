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
       // XInfoInsert::connect()->sql('news',$arra,$arra1)->query();
		$arra2 = array("title", "short_content", "date");

		//$info1 = XinfoSelect::connect()->sql('news1',$arra2)->query();
		//echo XinfoInsert::connect()->select('news', $info1,$arra2)->query();
		$ar1 = array('title'=>"6");
		$ar2 = array('id' => 1);
		//array('title:<='=>"green", 'date:OR:>'=>"green");
        $arraySql = array('newsToo.title' => "infoCMS112");
        $arrayWhere = array('news.id' => 6);
        $Update = XinfoUpdate::connect();
        return $Update->join("newsToo",array('news.newsToo' => "newsToo.id"))->sql('news',$arraySql)

        ->where($arrayWhere)
        ->run();
        //$arrayWhere = array('id' => 1);
        //$arraySql = array('title'=>"infoCMS","titleToo" => 2);


       // $Update = new XinfoUpdate();
      // echo $Update::connect()->sql('news',$arraySql)->query();
       //echo XinfoSelect::connect()->sql('news')
        //   ->join("user:left",array("user.id:AND" => "20","user.title:AND" => "news.title"))
            //->join("user:RIGHT",array("id" => "id1"))
          //  ->Where(array("news.title" => 3))
          //   ->orderBy(['id:ASC'])
            //->limit(2)
            //->offset(0)
         //   ->query();



	}
	public static function runId($id)
	{
		$ar = array('id' => $id);
		return XinfoSelect::connect()->sql('news',array("title"))
							 ->where($ar)
							 ->run();

	}
}