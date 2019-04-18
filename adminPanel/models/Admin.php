<?php
namespace adminPanel\models;
use components\inClass\XInfoSelect;
use components\inClass\XInfoInsert;
use components\inClass\XInfoUpdate;
    class Admin
    {
        public static function run()
        {
            $arra = array(
                array(null, 'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1', 'erterte1', 'terter3', 'ertert4'),
                array(null, 'fgdfgfgd1', '2018-05-10 00:00:00', 'tertert1', 'erterte1', 'erterte1', 'terter3', 'ertert4')
            );
            $arra1 = array('id', 'title', 'date', 'short_content', 'content', 'autor_name', 'type', 'preview');
            //Insert::connect()->sql('news',$arra)->run();
            $ar = array('id', 'title');

            return XinfoSelect::connect()->sql('news', $ar)
                //->join("user:left",array("user.id" => "news.id1"))
                //->join("user:RIGHT",array("id" => "id1"))
                ->underWhere(array("news.id" => 1))
                ->orderBy(['id:ASC'])
                //->limit(2)
                //->offset(0)
                ->query();

        }

        public static function runId($id)
        {
            $ar = array('id' => $id);
            return XinfoSelect::connect()->sql('news1', array("title"))
                ->where($ar)
                ->run();

        }
    }
