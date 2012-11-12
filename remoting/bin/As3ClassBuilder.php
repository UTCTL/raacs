<?php

include_once('ClassBuilder.php');

class As3ClassBuilder extends ClassBuilder
{
	private $sql2as3 = array(
				"int" => "int",
				"tinyint" => "int",
				"double" => "Number",
				"varchar" => "String",
				"text" => "String",
				"datetime" => "String",
				"timestamp" => "String",
				"enum" => "String");
	
	private $package;

	public function __construct($table,$output_dir,$package='')
	{
		parent::__construct($table,$output_dir);

		$this->package = $package;
	}

	public function writeClass()
	{
		$class_name = $this->makeClassName('VO');
		$file_name = $class_name.".as";
		$vars = array();
		
		foreach($this->table_description as $col)
		{
			$vars[] = $this->makeAs3Var($col);
		}
		
		ob_start();
?>
package <?php echo $this->package?>

{
	[Bindable]
	[RemoteClass(alias="<?php echo $class_name?>")]
	public class <?php echo $class_name?>
	
	{
		<?php echo implode("\n\t\t",$vars)?>
		
	}
}


<?php	
	
		if(!file_exists($this->output_dir."/".$file_name))
		{
			$fp = fopen($this->output_dir."/".$file_name,'w');
			fwrite($fp,ob_get_flush());
			fclose($fp);
		}
	
	}

	private function makeAs3Var($array)
	{

		$parts = explode("(",$array[1]);

		$varString = "public var ".$array[0].":".$this->sql2as3[$parts[0]].";"; 

		return $varString;
	}
}
?>