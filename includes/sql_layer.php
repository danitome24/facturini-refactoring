<?php

class ResultSet
{
    var $result;
    var $total_rows;
    var $fetched_rows;

    function set_result($res)
    {
        $this->result = $res;
    }

    function get_result()
    {
        return $this->result;
    }

    function set_total_rows($rows)
    {
        $this->total_rows = $rows;
    }

    function get_total_rows()
    {
        return $this->total_rows;
    }

    function set_fetched_rows($rows)
    {
        $this->fetched_rows = $rows;
    }

    function get_fetched_rows()
    {
        return $this->fetched_rows;
    }

    function increment_fetched_rows()
    {
        $this->fetched_rows = $this->fetched_rows + 1;
    }
}


function sql_connect($host, $user, $password, $db)
{
    if (!$dbi = mysqli_connect($host, $user, $password)) {
        die('error connection db');
    }
    mysqli_select_db($dbi, $db);

    return $dbi;
}

function sql_logout($id)
{
    global $dbtype;
    switch ($dbtype) {

        case "MySQL":
            $dbi = @mysqli_close($id);
            return $dbi;
            break;
        default:
            break;
    }
}


/*
 * sql_query($query, $id)
 * executes an SQL statement, returns a result identifier
 */

function sql_query($query, $id)
{
    global $sql_debug;
    $sql_debug = 0;
    if ($sql_debug) {
        echo "SQL query: " . str_replace(",", ", ", $query) . "<BR>";
    }
    $res = mysqli_query($id, $query);
    return $res;
}

/*
 * sql_num_rows($res)
 * given a result identifier, returns the number of affected rows
 */

function sql_num_rows($res)
{
    global $dbtype;
    switch ($dbtype) {

        case "MySQL":
            $rows = mysqli_num_rows($res);
            return $rows;
            break;
        default:
            break;
    }
}

/*
 * sql_fetch_row(&$res,$row)
 * given a result identifier, returns an array with the resulting row
 * Needs also a row number for compatibility with PostgreSQL
 */

function sql_fetch_row(&$res, $nr = 0)
{
    global $dbtype;
    switch ($dbtype) {

        case "MySQL":
            $row = mysqli_fetch_row($res);
            return $row;
            break;
        default:
            break;
    }
}

/*
 * sql_fetch_array($res,$row)
 * given a result identifier, returns an associative array
 * with the resulting row using field names as keys.
 * Needs also a row number for compatibility with PostgreSQL.
 */

function sql_fetch_array(&$res, $nr = 0)
{
    global $dbtype;
    switch ($dbtype) {
        case "MySQL":
            $row = array();
            $row = mysqli_fetch_array($res);
            return $row;
            break;
        default:
            break;

    }
}

function sql_fetch_object(&$res, $nr = 0)
{
    global $dbtype;
    switch ($dbtype) {
        case "MySQL":
            $row = mysqli_fetch_object($res);
            if ($row) {
                return $row;
            } else {
                return false;
            }
            break;
        default:
            break;

    }
}

/*** Function Free Result for function free the memory ***/
function sql_free_result($res)
{
    global $dbtype;
    switch ($dbtype) {

        case "MySQL":
            $row = mysqli_free_result($res);
            return $row;
            break;
        default:
            break;
    }
}

?>
