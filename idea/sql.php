<?php
/*
 * Author : Raphael Rajiv Ragoomundun
 * E-Mail : raphael.ragoomundun@openmailbox.org
 * Creation date : Thursday 18 February 2016, 11:42:44
 * 
 * sql.php : Functions for database connexion and query execution.
 */

require_once('config.php');

/*
 * sql_connect - Connect to the database and save PDO object in @GLOBALS['db']
 *
 * Return values :
 *
 * - 1 on success
 * - -1 if an error occur
 */

function sql_connect()
{
	try
	{
		$GLOBALS['db'] = new PDO(DSN, DB_USR, DB_PASS);

		$GLOBALS['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$GLOBALS['db']->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 
		PDO::FETCH_ASSOC);
	}
	catch(PDOException $error)
	{
		echo $error->getMessage();
		return -1;
	}

	return 1;
}

/*
 * sql_query - Execute an sql query.
 *
 * @query : the query type can be SELECT, INSERT, UPDATE, or DELETE. 
 *          If it's SELECT return a 2D array on success with all the fetched 
 *          informations. For other type query it return the return value of the
 *          execution.
 *
 * Return values :
 *
 * - the selected lines if it's a SELECT operation
 * - the affected lines if it's a INSERT, UPDATE, or DELETE operation
 * - -1 if the query type is incorrect
 */

function sql_query($query)
{
	if(preg_match('#SELECT #', $query))
	{
		$query_exec = $GLOBALS['db']->query($query);
		$answer = $query_exec->fetchAll();

		$query_exec->closeCursor();

		return $answer;
	}
	else if(preg_match('#INSERT |UPDATE |DELETE #', $query))
		return $GLOBALS['db']->exec($query);

	return -1;
}
?>
