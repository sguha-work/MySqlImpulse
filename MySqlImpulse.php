<?PHP
//****************************************
/**
*PACKAGE NAME:MYSQLIMPULSE
*CREATED BY: SAHASRANGSHU GUHA
*CREATED ON:11 JUN 2013
*MODIFIED ON:23 OCT 2013
*VERSION:1.2.1
*/
/**
*CHANGE LOG:
*1>A METHOD NAMED GETMAXVALUE() IS ADDED TO GET THE MAX VALUE OF A COLOUMN
*OF A PERTICULER TABLE
*/
//****************************************

?>
<?php
error_reporting(E_ALL);
define("IMPULSE_BASEPATH", realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
include_once 'database.php';
include_once 'configure.php';
include_once IMPULSE_BASEPATH.'system/errorText.php';
include_once IMPULSE_BASEPATH.'system/Cache.php';
include_once IMPULSE_BASEPATH.'system/QueryQueue.php';
include_once IMPULSE_BASEPATH.'system/CacheManager.php';
final class MySqlImpulse {
	//MEMBER VARIABLES AND CONSTRUCTORS
	private $_databaseName="";
	private $_databaseUserName="";
	private $_databasePassword="";
	private $_databaseAddress="";

	function __construct()	{
     	$this->_databaseAddress=DATABSE_ADDRESS;
     	$this->_databaseUserName=DATABSE_USER;
    	$this->_databasePassword=DATABSE_PASSWORD;
   	  $this->_databaseName=DATABSE_NAME;
	}
	//FINISHED MEMBER VARIABLES AND CONSTRUCTORS

  /**
  *This function is responsible for executing a query.$query=The query
  *$dataArray=data that will be intregrated in the query
  *The data will be autometically checked for harmful charecters,all html 
  *tags will be removed from the data.If you wish to use original data
  *use executeDirectQuery($query,$dataArray)
  *return FALSE if select query is unable fetch any data from database
  */
	final public function executeQuery($query,$dataArray=array()) {
   	$sqlQuery=$query;
   	if(count($dataArray)!=0) {
	  	$sqlQuery=$this->buildQuery($query,$dataArray);
	  }
   	return $this->execute($sqlQuery);
	}
 /**
 *This function is responsible for executing a query directly,that means
 *the provided data will not be checked for sql injectable charecters.
 *$query=The sql query which will be executed
 *$dataArray=The data to build the query
 *return FALSE if select query is unable fetch any data from database
 */
	final public function executeDirectQuery($query,$dataArray=array())	{
    $sqlQuery=$this->buildQuery($query,$dataArray,false);
    return $this->execute($sqlQuery);
	}

  /**
  *THIS FUNCTION THE MAXIMUM VALUE OF A COLOUMN OF A TABLE
  *THE COLOUMN MUST BE A NUMBER IN NATURE
  *$tableName=THE TABLE NAME FROM WHERE THE COLOUMN WILL BE SEARCHED
  *$coloumnName=THE COLOUMN NAME FROM WHICH THE MAXIMUM DATA WILL BE SEARCHED
  */
  final public function getMaxValue($tableName="",$coloumnName="")   {
    if($tableName==""||$coloumnName=="") {
      die(NOT_ENOUGH_ARGUMENT_SUPPLIED);
    }
    else {
      return $this->returnMaxValue($tableName,$coloumnName);
    }
  }
  
  /**
  *This function is responsible fro executing the query
  */
  private function execute($sqlQuery) {
    $sqlQueryArray=explode(" ",$sqlQuery);
    if($sqlQueryArray[0]=="SELECT") {
      return $this->executeSelectQuery($sqlQuery);
    }
    $_mysqliInstance=$this->getMySqliObject();
    try {
      $result=$_mysqliInstance->query($sqlQuery);
    }
    catch(Exception $ex) {
      die(DATABASE_ERROR);
    }
    return $result;
  }

  /**
  *This function execute the select query
  */
  private function executeSelectQuery($selectQuery) {
    $cacheManagerObject = new CacheManager();
    $isQueryExists = $cacheManagerObject->isQueryExitsInCache($selectQuery);
    if($isQueryExists === "FALSE") {
        $_mysqliInstance=$this->getMySqliObject();
        try {
          $selectResultSet=$_mysqliInstance->query($selectQuery);//GETTING RESULTSET BYEXECUTING THE QUERY
        }
        catch(Exception $ex) {
          die(DATABASE_ERROR);
        }
        $affectedRow=$_mysqliInstance->affected_rows;
        if($affectedRow==0) {
          return 0;
        }
        $selectedRows=array();
        while($selectedRow=$selectResultSet -> fetch_array(MYSQLI_BOTH)) {
            array_push($selectedRows, $selectedRow);
        }
        $selectResultSet -> free();
        $_mysqliInstance -> close();
        $cacheManagerObject -> saveDataToCache($selectQuery, $selectedRows);
    }
    else {
       $selectedRows = $cacheManagerObject -> getDataFromCache($selectQuery); 
    }
    return $selectedRows;
  }

  /**
  *This function returns the mysqli object based on the database.php's database infos
  */
  private function getMySqliObject() {
    $_mysqliObject=new mysqli($this->_databaseAddress,$this->_databaseUserName,$this->_databasePassword,$this->_databaseName);
    if($_mysqliObject->connect_errno!=0) {
      die(CONNECTION_ERROR);
    }
    else {
      return $_mysqliObject;
    }
  }

  /**
  *This function builds the query from the query and the data array
  */
	private function buildQuery($query,$dataArray,$checkData=true) {
    $numberOfQuestionMark=substr_count($query,"?");
    $numberOfDataInDataArray=count($dataArray); 
    if($numberOfQuestionMark!=$numberOfDataInDataArray) {
      die(NOT_ENOUGH_ARGUMENT_SUPPLIED);
    }
  	$sqlQuery="";
    $queryLength=strlen($query);
    $queryArray=str_split($query);
    $index=0;
    for($counter=0;$counter<$queryLength;$counter++) {
      if($queryArray[$counter]=="?") {
        if($checkData) {
         	$data=$this->cleanData($dataArray[$index]);
        }
        else {
        	$data=$dataArray[$index];
        }
        $index+=1;
        $sqlQuery.=$data;
      }
      else {
       	$sqlQuery.=$queryArray[$counter];
      }
    }
    return $sqlQuery;
	}
	private function cleanData($data) {
	  $_mysqliInstance=$this->getMySqliObject();
	  $string = strip_tags($data);
    if(get_magic_quotes_gpc()) {
      $string = stripslashes($string);
    }
    $string = mysqli_real_escape_string($_mysqliInstance,$string);
    return $string;
  }
  private function returnMaxValue($tableName,$coloumnName) {
    $maxValue=0;
    $selectQuery="SELECT MAX(".$coloumnName.") AS id FROM ".$tableName;
    $result=$this->executeSelectQuery($selectQuery);
    $row=$result[0];
    if($row['id']==NULL||$row['id']=="") {
      return $maxValue;
    }
    else {
      $maxValue=intval($row['id']);
      return $maxValue;
    }
  }  
}
?>
