<?php

include_once('DBConn.php');

class ClassBuilder 
	{
	
		protected $table_name;
		protected $table_description;
		protected $output_dir;
		protected $db_connection;
	
		public function __construct($table,$output_dir)
			{
		
				$db_connection = DBConn::get();
		
				$this->table_name = $table;
				$this->output_dir = $output_dir;
				
				if(!file_exists($this->output_dir))
				   mkdir($this->output_dir, 0755);
				
				$col_query = $db_connection->query("DESCRIBE $table");
				$this->table_description = $col_query->fetchAll();
			}
		
		public function writeClass()
		{
			$class_name = $this->makeClassName();
			$file_name = $class_name.".php";
			
			$class_string = "class $class_name {}";
			
			if(!file_exists($this->output_dir."/".$file_name))
			{
				$fp = fopen($this->output_dir."/".$file_name,'w');
				fwrite($fp,$class_string);
				fclose($fp);
			}
			
		}
		
		protected function makeClassName($suffix='')
			{
				$class_name = "";
				$a = explode("_",$this->table_name);

				foreach($a as $part){
					$class_name .= ucfirst($part);
					}

				return $class_name.$suffix;
			}
	
	}
?>