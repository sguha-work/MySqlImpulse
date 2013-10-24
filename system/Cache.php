<?php
//THIS CLASS IS RESPONSIBLE TO WRITE DATA TO CACHE AND 
//GETTING VALUES FROM CASCHE 
class Cache
{
	private static $CacheArray=array();
	private static $cache_object=null;
	private function __construct() {

	}
	public static getCacheObject() {
		if( $cache_object == null ) {
			self :: $cache_object = new Cache();
		}
		return $cache_object;
	}
	public function writeToCache( $index, $data ) {
	  $serializeData = serialize($data);	
      if( $index == null ) {
      	die('Error:No Index Specified.Unable to write cahce');
      }
      self :: $CacheArray[ $index ] = serialize( $data );
      return true;
	}
	public function getFromCache($fileName)
	{
      $serializeData=file_get_contents($fileName);
      $data=array();
      $data=unserialize($serializeData);
      return $data;
	}
}
?>