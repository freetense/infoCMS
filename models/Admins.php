<?php
namespace models;
use components\inClass\XInfoSelect;
use components\inClass\XInfoInsert;
use components\inClass\XInfoUpdate;
class Admins
{
	public static function run(){
		$ar = array('id:count','title');
		$array = array(
			array("25",'title_insert', '2')
		);
		$array_1 = array('id', 'title', 'newsToo');
        //echo XInfoInsert::connect()->sql('news',$array,$array_1, "high")->query();
        $dpl = array("title" => "infodubl", "newsToo" => "4");
       // echo XinfoInsert::connect()->sql('news',$array,$array_1)->dupl($dpl)->query();
       // return XinfoInsert::connect()->sql('news',$array,$array_1)->dupl($dpl)->run();

        $array_1 = array('id', 'title');
		$array_2 = array("null", "title");
        $dpl = array("title" => "info","id" => "2");
		$infoSelect = XinfoSelect::connect()->sql('news',$array_2)->query();
		return XinfoInsert::connect()->select('newsToo', $infoSelect,$array_1)->run();
		//$ar1 = array('title'=>"6");
		//$ar2 = array('id' => 1);
		//array('title:<='=>"green", 'date:OR:>'=>"green");
        //$arraySql = array('title' => "infoCMS");
        //$arrayWhere = array('news.id:<=:or' => 3,'news.id:>:AND' => 3);
        //$Update = XinfoUpdate::connect();
        //echo $Update
            //->join("newsToo",array('news.newsToo' => "newsToo.id"))
            //->sql('news',$arraySql)

            //->orderBy(['id:DESC'])
            //->limit(2)
       // ->where($arrayWhere)
       // ->query();
        //$arrayWhere = array('id' => 1);
        //$arraySql = array('title'=>"infoCMS","titleToo" => 2);


       // $Update = new XinfoUpdate();
      // echo $Update::connect()->sql('news',$arraySql)->query();
       //echo XinfoSelect::connect()->sql('news')
        //->join("user:left",array("user.id:or" => "20","user.title:AND" => "news.title","user.title1" => "news.title"))
            //->join("user:RIGHT",array("id" => "id1"))
         //  ->Where(array("news.title:>:OR" => 3,"news.title:<" => 3))
          //   ->orderBy(['id:ASC'])
            //->limit(2)
            //->offset(0)
           // ->query();

       // $Select = XinfoSelect::connect();
       // echo $Select->sql('news',array("title"))->groupBy(array("id","title"),array("id:>" => 3,"id:<=:or" => 10))->query();

	}
	public static function runId($id)
	{
		$ar = array('id' => $id);
		return XinfoSelect::connect()->sql('news',array("title"))
							 ->where($ar)
							 ->run();

	}
}