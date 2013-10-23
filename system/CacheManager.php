<?php
//THIS CLASS IS RESPONSIBLE TO MANAGE THE CAHCE
class CacheManager
{
	public static $cacheIndex=array();
	public static $_cachemanagerInstance=null;
	public function getInstance()
	{
       if(self::$_cachemanagerInstance==null)
       	self::$_cachemanagerInstance=new CacheManager();
       return self::$_cachemanagerInstance;
	}
}
?>