<?php
class XInfoUpdate
{
	protected static $instance; 
	public $query;
	private $arr;
	private $result;
	private $val;
	private $table;
	private $arrWhere;
	public static function connect() {
        if ( !isset(self::$instance) ) {
            $class = __CLASS__;
            self::$instance = new $class();
            return self::$instance;
        }
        return self::$instance;
  	}
	public function query(){
		$querys = "UPDATE $this->table " . $this->query;	
		$this->query = "";
		return $querys;
	}
	public function run(){
		$db = XInfoDb::getConnection();
		$this->query = "UPDATE $this->table " . $this->query;
		$this->result = $db->prepare($this->query);
        $this->result->execute($this->arr);
		$this->query = "";
	}
	public function join($one, $too){
		$array = array("LEFT","RIGHT","INNER","FULL");
		$operator = '';
		for ($i=0; $i <=3; $i++) { 
			$position = strripos($one, ':'.$array[$i]);         		
         	if($position != false){
         		$one = str_ireplace(':'.$array[$i], "", $one);
         		$operator = $array[$i];
         		if($operator == "FULL"){
         			$operator = "FULL OUTER";
         		}
            }
				$position = false;
		}
		$vals = true;
		foreach ($too as $key => $value) {
			$operators = 'AND';
			$array = array("OR","AND");
			for ($i=0; $i <=1; $i++) { 
				$position = strripos($key, ':'.$array[$i]);
         		
         		if($position != false){
         			unset($too[$key]);
         			$key = str_ireplace(':'.$array[$i], "", $key);
         			$too[$key] = $value;
         			$operators = $array[$i];	
            	}
				$position = false;
			}
			if($vals == false){
				$colums = $colums . " $operators "
						  . $key 
		   				  . " = " . $value;
		    }else{
		   		$colums = ' ON (' . $key 
		   				  . " = " . $value;
		   	}
				$vals = false;
		}
		$this->query = $this->query 
			. " $operator JOIN `$one` $colums)";  
		return $this;
	}		
	public function sql($news, $value, $disct  = false)
	{
		$arrSql = array();
		$vals = true;
		$s = 1;
         foreach ($value as $key => $values) {
         	$key1 = str_ireplace('.', "", $key);
         	$key1 = explode(":", $key1);
         	$key = explode(":", $key);
			if($vals == false){
				$colums =   $colums . ', ' . $key[0]."= :" . $key1[0].$s; 
		    }else{
		   		$colums = $key[0]." = :" . $key1[0].$s;
		   	}
		   	$arrSql[$key1[0].$s] = $values;
				$vals = false;
				$s++;
		}
         print_r($arrSql);
		$this->query = $this->query . " SET $colums ";
		$this->arr = $arrSql;
		$this->table = $news;
		return $this;
	}
	public function orderBy($news, $sort = "ASC"){
			$vals = true;
			$array = array("ASC","DESC");
         	foreach ($news as $key => $value) {
         	$operator = 'ASC';
			for ($i=0; $i <=1; $i++) { 
				$position = strripos($value, ':'.$array[$i]);
         		
         		if($position != false){
         			$value = str_ireplace(':'.$array[$i], "", $value);
         			$news[$key] = $value;
         			$operator = $array[$i];	
            	}
				$position = false;
			}
				if($vals == false){
					$colums =   $colums . ',' . '`' . $value . '` ' . $operator;
		    	}else{
		   			$colums = '`' . $value . '` ' . $operator;
		   		}
					$vals = false;
			}
		$this->query = $this->query 
			. " ORDER BY $colums ";  
		return $this;
	}
	public function where($news = array())
	{
		$val = true;
		$this->query = $this->query . ' WHERE ';
		$arr = array('>=','<=','<>','=','<','>','LIKE');
		$arr_value = array("IS NULL", "IS NOT NULL");
		$array = array("OR","AND");
		$s = 1;
		foreach ($news as $key => $value) {
			$prefix = '=';
			unset($news[$key]);
			for ($i=0; $i <=6; $i++) { 
				$position = strripos($key, ':'.$arr[$i]);
         		
         		if($position != false){
         			$key = str_ireplace(':'.$arr[$i], "", $key);
         			;
         			$prefix = $arr[$i];	
            	}
				$position = false;
			}
				$operator = 'AND';
			for ($i=0; $i <=1; $i++) { 
				$position = strripos($key, ':'.$array[$i]);
         		
         		if($position != false){
         			$key = str_ireplace(':'.$array[$i], "", $key);
         			$operator = $array[$i];	
            	}
				$position = false;
			}
			$key1 = str_ireplace('.', "", $key);
			$prefix = $prefix
					  . " :"
					  . $key1.$s
					  . " ";
			$news[$key1.$s] = $value;
			foreach ($arr_value as $keys => $values) {
				if($values == $value){
					$prefix = $value;
					unset($news[$key1.$s]);
				}
			}
			$s++;
			if($val == false){
				$this->query =  $this->query . " $operator "
					. $key 
					. " "
					. $prefix;
		    	}else{
					$this->query = $this->query 
					. $key 
					. " "
					. $prefix;
				}
				$val = false;
				
				
		}
		$this->arr = array_merge($this->arr, $news);
		return $this;
	}
	public function limit($one){
		$this->query = $this->query 
			. " LIMIT $one";  
		return $this;
	}
}
	?>