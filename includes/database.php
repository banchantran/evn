<?php
//	Chuc nang chinh  	: 	Cac ham xu ly database

class database {
	/** @var string Internal variable to hold the query sql */
	var $_sql			= '';
	/** @var Internal variable to hold the connector resource */
	var $_resource		= '';
	/** @var Internal variable to hold the last query cursor */
	var $_cursor		= null;
	/** @var int A counter for the number of queries performed by the object instance */
	var $_ticker		= 0;
	/** @var array A log of queries */
	var $_log			= null;
	/** @var errorNum */
	var $_errorNum			= '';

	/**
	* Database object constructor
	* @param string Database host
	* @param string Database user name
	* @param string Database user password
	* @param string Database name
	* @param boolean If true and there is an error, go offline
	*/
	function database($host='localhost', $user, $pass, $db='')
	{
		$this->_resource = mysql_connect($host, $user, $pass) or die(_ERROR_CONNECT_DATABASE);
		mysql_select_db($db,$this->_resource) or die(_ERROR_SELECT_DATABASE.$db);
		$this->_ticker = 0;
	}
	/**
	 * @return int The error number for the most recent query
	 */
	function getErrorNum() {
		return $this->_errorNum;
	}
	/**
	* @return string The error message for the most recent query
	*/
	function getErrorMsg() {
		return str_replace( array( "\n", "'" ), array( '\n', "\'" ), $this->_errorMsg );
	}
	function getTicker()
	{
		return $this->_ticker;
	}
	/**
	* Sets the SQL query string for later execution.
	*
	*
	* @param string The SQL query
	* @param string The offset to start selection
	* @param string The number of results to return
	*/
	function setQuery($sql)
	{
		$this->_sql = $sql;
	}
	/**
	* Execute the query
	* @return mixed A database resource if successful, FALSE if not.
	*/
	function query()
	{
		$this->_ticker++;
		$this->_cursor = mysql_query($this->_sql, $this->_resource);
		if (!$this->_cursor)
		{
			$this->_errorNum = mysql_errno($this->_resource);
			$this->_errorMsg = mysql_error($this->_resource)." SQL=$this->_sql";
			return false;
		}
		return $this->_cursor;
	}
	/**
	* @return int The number of rows returned from the most recent query.
	*/
	function getNumRows($table, $condition = '')
	{
		if($condition)
			$this->setQuery('select id from `'.$table.'` where '.$condition);
		else
			$this->setQuery('select id from `'.$table.'`');
		
		$this->query();
		return mysql_num_rows($this->_cursor);
	}
	/**
	* @return The first row of the query.
	*/
	function loadRow() {
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = mysql_fetch_array($cur)) {
			$ret = $row;
		}
		mysql_free_result($cur);
		return $ret;
	}
	/**
	* This method loads the first field of the first row returned by the query.
	*
	* @return The value returned in the query or null if the query failed.
	*/
	function loadResult()
	{
		if (!($cur = $this->query())) {
			return null;
		}
		while($row = mysql_fetch_assoc($cur))
		{
			$array[$row['id']] = $row;
		}
		mysql_free_result( $cur );
		return $array;
	}
	/**
	* Document::db_insertObject()
	*
	* { Description }
	*
	* @param [type] $keyName
	* @param [type] $verbose
	*/
	function insertObject($table, $values)
	{
		$query = "INSERT INTO $table (";
		$i=0;
		if($values)
		{
			foreach($values as $key=>$value)
			{
				if($i<>0)
				{
					$query.=',';
				}
				$query.='`'.$key.'`';
				$i++;
			}
			$query.=') values (';
			$i=0;
			foreach($values as $key=>$value)
			{
				if($i<>0)
				{
					$query.=',';
				}

				if($value=='NULL')
				{
					$query.='NULL';
				}
				else
				{
					$query.='\''.mysql_real_escape_string($value).'\'';
				}
				$i++;
			}
			$query.=')';
			$this->setQuery($query);
			if($this->query($query))
			{
				$id = mysql_insert_id($this->_resource);
				return $id;
			}
		}
	}
	/**
	* Document::db_updateObject()
	*
	* { Description }
	*
	* @param [type] $updateNulls
	*/
	function updateObject($table, $values, $condition)
	{
		$query='update `'.$table.'` set ';
		$i=0;
		if($values)
		{
			foreach($values as $key=>$value)
			{
				if($i<>0)
				{
					$query.=',';
				}
				if($value=='NULL')
				{
					$query.='`'.$key.'`=NULL';
				}
				else
				{
					$query.='`'.$key.'`=\''.mysql_real_escape_string($value).'\'';
				}
				$i++;
			}
			$query.=' where '.$condition;
			$this->setQuery($query);
			if($this->query($query))
			{
				return true;
			}
		}
		return false;
	}
	/**
	* @param boolean If TRUE, displays the last SQL statement sent to the database
	* @return string A standised error message
	*/
	function stderr($showSQL = false ) {
		return "DB function failed with error number $this->_errorNum"
		."<br /><font color=\"red\">$this->_errorMsg</font>"
		.($showSQL ? "<br />SQL = <pre>$this->_sql</pre>" : '');
	}
	function close()
	{
		if ($this->_resource)
		{
			mysql_close($this->_resource);
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
