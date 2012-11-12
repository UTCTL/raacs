<?php

include_once('ClassBuilder.php');

class PhpClassBuilder extends ClassBuilder 
{
	private $exclude;
	private $gen_dir;
	
	public function __construct($table,$output_dir,$exclude=NULL)
	{
		parent::__construct($table,$output_dir);
		
		$this->gen_dir = $output_dir."/generated";
		
		if(!file_exists($gen_dir))
			mkdir($this->gen_dir, 0755);
		
		if($exclude)
			$this->exclude = $exclude;
			else
				$this->exclude = array();
	}
	
	public function writeClass()
	{
		$class_name = $this->makeClassName();
		$file_name = $class_name.".php";
		$property_list = array();
		$columns = array();
		$insert_columns = array();
		$parameters = array();
		$update_values = array();
		
		foreach($this->table_description as $col)
		{
			$property_list[] = "public $".$col[0].";";
			$columns[] = $col[0];
			
			if(!in_array($col[0],$this->exclude) && $col[0] != 'id')
			{
				$insert_columns[] = $col[0];
				$update_values[] = '`'.$col[0].'` = ?';
				$parameters[] = "?";
			}	
		}
		
		ob_start();
		echo "<?php\n\n";
		?>
include_once('DBConn.php');

class <?php echo $class_name?>

{
	<?php echo implode("\n\t",$property_list);?>
	
	
	protected $db_connection;
	
	const TABLE = "<?php echo $this->table_name?>";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `<?php echo $this->table_name?>` WHERE `<?php echo $columns[0]?>` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `<?php echo $this->table_name?>` (<?php echo '`'.implode("`,`",$insert_columns).'`'?>) VALUES (<?php echo implode(",",$parameters)?>)");
			$query->execute(array(<?php echo "\$this->".implode(", \$this->",$insert_columns);?>));
			$this->id = $this->db_connection->lastInsertId();
			
			if($this->id)
	        	return $this->id;
	        	else
	        		return 0;
		}
		else
			return 0;
	}
	
	public function edit()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("UPDATE `<?php echo $this->table_name?>` SET <?php echo implode(", ",$update_values);?> WHERE `<?php echo $columns[0]?>` = ?");
			$query->execute(array(<?php echo "\$this->".implode(", \$this->",$insert_columns).", \$this->id";?>));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM <?php echo $this->table_name?> WHERE `<?php echo $columns[0]?>` = ?");
			$query->execute(array($this->id));
		}
	}
	
	public function save()
	{
		if($this->id)
			$this->edit();
			else
				$this->add();
	}
	
}
<?php
		echo "?>";
		$class_string = ob_get_flush();
		
		if(!file_exists($this->gen_dir."/".$file_name))
		{
			$fp = fopen($this->gen_dir."/".$file_name,'w');
			fwrite($fp,$class_string);
			fclose($fp);
		}
		
		//Generate Extended Class
		$extended_class_name = $this->makeClassName('VO');
		
		$class_string = "<?php\ninclude_once('generated/$file_name');\n\n";
		$class_string .= "class $extended_class_name extends $class_name\n{\n\n}\n?>";
		
		if(!file_exists($this->output_dir."/".$extended_class_name.".php"))
			{
				$fp = fopen($this->output_dir."/".$extended_class_name.".php",'w');
				fwrite($fp,$class_string);
				fclose($fp);
			}
		
	}	
}
?>