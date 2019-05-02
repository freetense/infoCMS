<?php
namespace components\inClass;
use components\inClass\XInfoDb;
class XInfoInsert
{
	protected static $instance; 
	public $query;
	private $arr;
	private $result;
	private $table;
	private $info;
	public static function connect() {
        if ( !isset(self::$instance) ) {
            $class = __CLASS__;
            self::$instance = new $class();
            return self::$instance;
        }
        return self::$instance;
  	}
  	public function run($news = false){
		$db = XInfoDb::getConnection();
		if($news != false){

			$this->result = $db->prepare($news);
			$this->result->execute();
		}else{
			if($this->info == "info"){
				$this->result = $db->prepare($this->query);
        		$this->result->execute();

			}else{
				$this->result = $db->prepare($this->query);
        		$this->search($this->arr);
			}
        }
        $this->info = "";
        $this->query = "";
    }
    public function search($news = null)
	{
		if($news != null){
			$array = array();
			$i = 1;
			foreach ($news as $key => $value) 
			{
				if(is_array($value)){
					foreach ($value as $keys => $values) 
					{
						$array[":key".$i] = $values;
						$i++;
					}
				}else{
					$array[":key".$key] =  $value;
					$i++;
				}			
			}
			$this->result->execute($array);
		}else{
    	 	$this->result->execute();
    	}
	}
    public function dupl($value = false)
    {
        $valDup = false;
        $infoDupl = "";
        if($value != false) {
            foreach ($value as $key => $values) {
                if($valDup == false) {
                    $infoDupl = $infoDupl . " "
                        . $key . " = \"" . $values. "\"";
                }else{
                    $infoDupl = $infoDupl . ", "
                        . $key . " = \"" . $values . "\"";
                }
                $valDup = true;
            }
            $this->query = $this->query . " ON DUPLICATE KEY UPDATE "
                           . $infoDupl;
            return $this;
        }
    }
	public function sql($news, $value = false, $colums = false,$lowHigh = false)
	{
        $valLowHigh = "";
		$valInfo = array();
		$results = "";
		$resultsColums = "";
		if($value != false){
			$i = 1;
			$vals = true;
         	foreach ($value as $key => $values){
         		$valsArray = true;
				if(is_array($values)){
         			foreach ($values as $keys => $info){
         				if($valsArray == true){
         					$valInfo[$key] = '(:key'.$i;
         					$i++;
         				}else{
         					$valInfo[$key] .=  ', :key'.$i;
         					$i++;
         				}
         				$valsArray = false;
         			}
         			$valInfo[$key] .= ')';
         		}else{
         			if($vals == true){
         				$valInfo[0] =  '(:key'.$key;
         				$vals = false;
         			}else{
         				$valInfo[0] .=  ', :key'.$key;
         			}
         		}
			}
			if($vals == false){
				$valInfo[0] .= ')';
			}
			$vals = true;
			foreach ($valInfo as $key => $values) {
         		if($vals == true){
         			$results  = $valInfo[$key];
         			$vals = false;
         		}else{
         			$results .=  ','.$valInfo[$key];
         		}
         	}
         	if($colums != false){
         		$vals = true;
         		foreach ($colums as $key => $values) {
         			if($vals == true){
         				$resultsColums  = '( '.$values;
         				$vals = false;
         			}else{
         				$resultsColums .=  ','.$values;
         			}
         		}
         		$resultsColums .= ')';
         	}
		}
        if ($lowHigh != false){
            if(strtolower($lowHigh) == "low"){
                $valLowHigh = " LOW_PRIORITY ";
            }elseif( strtolower($lowHigh) == "high"){
                $valLowHigh = " HIGH_PRIORITY ";
            }else{
                $valLowHigh = "";
            }
        }
		$this->query = "INSERT $valLowHigh INTO $news $resultsColums "
			.' VALUES '
			.$results;
			$this->table = $news;
			$this->arr = $value;
		return $this;
	}
		public function select($news, $select = false, $colums = false,$lowHigh = false)
	{
	    $valLowHigh = "";
		$resultsColums = "";
	    if($colums != false){
         		$vals = true;
         		foreach ($colums as $key => $values) {
         			if($vals == true){
         				$resultsColums  = '( '.$values;
         				$vals = false;
         			}else{
         				$resultsColums .=  ','.$values;
         			}
         		}
         		$resultsColums .= ')';
        }
        $select =  str_replace("(", "", $select);
        $select =  str_replace(")", "", $select);
        $select =  str_replace("`", "", $select);
        if ($lowHigh != false){
            if(strtolower($lowHigh) == "low"){
                $valLowHigh = " LOW_PRIORITY ";
            }elseif( strtolower($lowHigh) == "high"){
                $valLowHigh = " HIGH_PRIORITY ";
            }else{
                $valLowHigh = "";
            }
        }
        $this->query = "INSERT $valLowHigh INTO $news$resultsColums "
			.$select;
		$this->info = "info";
		$this->table = $news;
		return $this;
	}
	public function query(){
		$querys = $this->query;
		$this->query = "";
		return $querys;

	}
}
?>