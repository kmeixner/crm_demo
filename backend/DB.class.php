<?php
require_once('settings.inc.php');


/**
 * @class DB
 *
 * This is a utility class that encapsulates database access. It allows 
 * SQL select, insert and updates operations and stores the database error 
 * if applicable.
 */
class DB {

	/**
	* @param string $strServername: the db host name, DEFAULT: use settings
	* @param string $strServername: the db username, DEFAULT: use settings
	* @param string $strServername: the db password, DEFAULT: use settings
	* @param string $strServername: the db name, DEFAULT: use settings
	*
	* @returns: NULL
	*/
	function __construct(
		$strServername=DB_SERVERNAME, 
		$strUsername=DB_USERNAME, 
		$strPwd=DB_PASS,
		$strDB=DB_NAME
	) {

		$conn = new mysqli($strServername, $strUsername, $strPwd, $strDB);

		if ($conn->connect_error) {
		  die("Database Connection failed: " . $conn->connect_error);
		} 

		$this->conn = $conn;

		return;
	}


	/**
	* Returns DB error
	*
	* @returns string: the error reported by the database
	*/
	function getError() {
		return $this->error;
	}

	/**
	* Returns the given SQL query results as an associative array.
	*
	* @param string $strSQL: the SQL query
	*
	* @returns array: the results or an empty array for no matches
	*/
	function query($strSQL) {

		$arrResults = array();

		$result = $this->conn->query($strSQL);

		if (0 == $result->num_rows)
			return array();

		while($row = $result->fetch_assoc()) {
			array_push($arrResults, $row);
		}

		return $arrResults;
	}

	/**
	* Performs and update or insert SQL operation.
	*
	* @param string $strSQL: the SQL update or insert statemetn
	*
	* @returns int: the insert id for INSERT INTO, TRUE for successful 
	* update or FALSE for failure
	*/   
	function update($strSQL) {

		if (FALSE != $this->conn->query($strSQL)) {

		  if (FALSE !== stripos($strSQL, 'INSERT INTO')) {
			return $this->conn->insert_id;
		  }
		  else {
			return TRUE;
		  }

		} else {
			$this->error = $this->conn->error;
			return FALSE;
		}   

	}

}

