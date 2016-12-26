<?php
if($_SERVER['REQUEST_URI'] == '/me/database.php'){header("location: 404.html");}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
class database
{
	
	protected $username="admin";
    protected $password="1212";
		private static $config;

	public function __construct()
	{
		define('URL','/me');
		try
		{
 $this->conn = new PDO("mysql:host=localhost;dbname=me",$this->username,$this->password);
		$this->conn->exec("set names utf8");
		// echo "connect!";
		}
		catch(PDOException $e)
		{
header ("location: /me/404.html");			
		}
	}
	

	
public function where($value) {

		$this->where = $value;
		
		return $this;
		
	}
	
	/**
	 * Executes an sql statement
	 *
	 * @access public 
	 */
     public function query($statement) {
		
	$checkRowCount=$this->conn->query($statement);
	if($checkRowCount->rowCount() == 0)
	{
		header("location: 404.html");
	}
	else
	{
		return $this->conn->query($statement);
	}		

	}

	/**
	 * Returns the number of rows affected
	 *
	 * @access public 
	 */	
    public function row_count($statement) {
	
		return $this->conn->query($statement)->rowCount();
		
    }

	/**
	 * Execute query and return one row in assoc array
	 *
	 * @access public 
	 */
    public function fetch_row_assoc($statement) {
		
		return $this->conn->query($statement)->fetch(PDO::FETCH_ASSOC);
		
    }
	
public function delete($table) {
            
		$sql = "DELETE FROM " . $table . " ";
		
		$counter = 0;
		
		foreach ($this->where as $key => $value) {

			if ($counter == 0) {
				
				$sql .= "WHERE {$key} = :{$key} ";
				
			} else {
				
				$sql .= "AND {$key} = :{$key} ";
				
			}
									
			$counter++;
			
		}
		
		$stmt = $this->conn->prepare($sql);
		
		foreach ($this->where as $key => $value)
			$stmt->bindValue(':' . $key, $value);
					
		if($stmt->execute() == '1')
		{
			header("location: " . URL   . "/admin/panel/?action=success");
		}
		else
		{
			header("location: " . URL   . "/admin/panel/?action=error");
		}
            
    }
	public function insert($table, $values) {			
		
		foreach ($values as $key => $value)
			$field_names[] = $key . ' = :' . $key;

		$sql = "INSERT INTO " . $table . " SET " . implode(', ', $field_names);

		$stmt = $this->conn->prepare($sql);
		
		foreach ($values as $key => $value)
			$stmt->bindValue(':' . $key, $value);
		if($stmt->execute() == '1')
		{
			header("location: " . URL   . "/admin/panel/?action=success");
		}
		else
		{
			header("location: " . URL   . "/admin/panel/?action=error");
		}
			
	}
	public function update($table, $values) {

		foreach ($values as $key => $value)
			$field_names[] = $key . ' = :' . $key;

		$sql  = "UPDATE " . $table . " SET " . implode(', ', $field_names) . " ";
		
		$counter = 0;
		
		foreach ($this->where as $key => $value) {

			if ($counter == 0) {
				
				$sql .= "WHERE {$key} = :{$key} ";
				
			} else {
				
				$sql .= "AND {$key} = :{$key} ";
				
			}
									
			$counter++;
			
		}
		
		$stmt = $this->conn->prepare($sql);
		
		foreach ($values as $key => $value)
			$stmt->bindValue(':' . $key, $value);
			
		foreach ($this->where as $key => $value)
			$stmt->bindValue(':' . $key, $value);

		if($stmt->execute() == '1')
		{
			header("location: " . URL   . "/admin/panel/?action=success");
		}
		else
		{
			header("location: " . URL   . "/admin/panel/?action=error");
		}
		
	}

}

?>