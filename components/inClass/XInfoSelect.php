<?php
class XInfoSelect
{
	protected static $instance; 
	public $query;
	private $arr;
	private $result;
	private $val;
	private $table;
	public static function connect() {
        if ( !isset(self::$instance) ) {
            $class = __CLASS__;
            self::$instance = new $class();
            return self::$instance;
        }
        return self::$instance;
  	}
	public function query(){

		$querys = $this->query . " )";
		$posit  = strripos($this->query, "UNION");
		if($posit > 0){
			$querys = trim($this->query, ")");
			$querys = trim($this->query, "(");
		}
		$this->query = "";
		return $querys;
	}
	public function run($news = false){
		$db = XInfoDb::getConnection();
		$newList = array();
		$this->query = $this->query." )";
		$posit  = strripos($this->query, "UNION");
		if($posit > 0){
			$this->query = trim($this->query, ")");
			$this->query = trim($this->query, "(");
		}
		if($news != false){
			$this->result = $db->prepare($news);
			$this->result->execute();
		}else{
			$this->result = $db->prepare($this->query);
        	$this->search($this->arr);
        }
		$this->result->setFetchMode(\PDO::FETCH_ASSOC);
		$array = array("COUNT(" => "count_","MAX(" => "max_","MIN(" => "min_");
		foreach ($this->result as $row) 
		{
			foreach ($row as $key => $value) 
			{
				foreach ($array as $keys => $values) 
				{
            		$position = strripos(' '.$key, $keys);
            		if($position != false){
            			unset($row[$key]);
         				$key = str_ireplace($keys, $values, $key);
         				$key = str_ireplace(")", "", $key);
            		}
            	}
				$row[$key] = $value;
			}
			$newList[] = $row;
		}
		$this->query = "";
		return $newList;
	}
	public function search($news = null)
	{
		if($news != null){
			$array = array();
			foreach ($news as $key => $value) 
			{
    			$array[":".$key] = $value;
			}
			$this->result->execute($array);
		}else{
    	 		$this->result->execute();
    	 	}
	}

	public function all($news,$count = false)
	{
		$posit  = strripos($this->query, "UNION");
		$union = "( ";
		if($posit > 0){
			$union = "";
		}
		if($count == true){
			$this->query = $this->query . $union . " SELECT COUNT(*)" 
			. " FROM `$news` ";
		}else{
			$this->query = $this->query . $union . " SELECT *" 
			. " FROM `$news` ";
		}
		$this->table = $news;
		return $this;
	}
	public function sql($news, $value = '*', $disct  = false)
	{
		if($value != '*'){
			$vals = true;
			$arr = array("COUNT" => ":count", "MAX" => ':max', "MIN" => ':min');
         	foreach ($value as $key => $value) {
         		foreach ($arr as $keys => $values) {
         			$position = strripos($value, $values);
         			$value = str_ireplace($values, "", $value);
         			if($position != false){
						$value = "$keys("
								 . $value 
							 	. ')';	
					}
				}
				if($vals == false){
					$colums =   $colums . ',' . $value;
		    	}else{
		   			$colums = $value;
		   		}
					$vals = false;
			}
		}else{
			$colums = $value;
		}
		if($disct == false){
			$disct = "";
		}else{
			$disct = "DISTINCT";
		}
		$posit  = strripos($this->query, "UNION");
		$union = "( ";
		if($posit > 0){
			$union = "";
		}
		$this->query = $this->query . $union . "SELECT $disct "
			. $colums
			. " FROM `$news` ";
			$this->table = $news;
		return $this;
	}
	public function union(){
		$this->query = $this->query . " UNION ";
		return $this;
	}
	public function groupBy($news,$having = false){
			$vals = true;
			$arr = array('>=','<=','<>','=','<','>');
			$array = array("OR","AND");
         	foreach ($news as $key => $value) {
				if($vals == false){
					$colums =   $colums . ',' . $value;
		    	}else{
		   			$colums = $value;
		   		}
					$vals = false;
			}
			$vals = true;
			if($having != false){
				foreach ($having as $key => $value) {
         		$prefix = '=';
				unset($having[$key]);
					for ($i=0; $i <=5; $i++) { 
						$position = strripos($key, ':'.$arr[$i]);
						if($position != false){
         					$key = str_ireplace(':'.$arr[$i], "", $key);
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
					if($vals == false){
						$colums =   $colums . " $operator $key "
									. " $prefix $value";
		    		}else{
		   				$colums = $colums
		   						  . " HAVING $key $prefix $value";
		   			}
					$vals = false;
				}
			}
		$this->query = $this->query 
			. " GROUP BY $colums ";  
		return $this;
	}
	public function limit($one, $too = false){
		if($too != false){
			$too = ",".$too;
		}else{
			$too = "";
		}
		$this->query = $this->query 
			. " LIMIT $one".$too." ";  
		return $this;
	}
	public function offset($one){

		$this->query = $this->query 
			. " OFFSET $one ";  
		return $this;
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
        $this->arr = $news;
		return $this;
	}
		public function underWhere($news = array())
	{
		$val = true;
		$this->query = $this->query . " WHERE ";
		$arr = array('>=','<=','<>','=','<','>','LIKE','IN','EXISTS','NOT IN','NOT EXISTS');
		$arr_value = array("IS NULL", "IS NOT NULL");
		$array = array("OR","AND");
		$s = 1;
		foreach ($news as $key => $value) {
			$prefix = '=';
			unset($news[$key]);
			for ($i=0; $i <=10; $i++) { 
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
					  . ' ' . $value
					  . ' ';
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
		return $this;
	}
}
