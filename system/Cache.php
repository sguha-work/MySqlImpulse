<?php
//THIS CLASS IS RESPONSIBLE TO WRITE DATA TO CACHE FILE AND 
//GETTING VALUES FROM CASCHE FILE
class Cache
{
	/*
	$fileName SHOULD BE THE CAHCE FILE NAME,AND $data WILL BE 
	THE ARRAY HOLDING THE RETURNED ROWS FROM DATABASE
	*/
	function writeToCache($fileName,$data)
	{
	  $serializeData=serialize($data);	
      $result=file_put_contents($fileName,$serializeData);
      return $result;
	}
	function getFromCache($fileName)
	{
      $serializeData=file_get_contents($fileName);
      $data=array();
      $data=unserialize($serializeData);
      return $data;
	}
}
?>