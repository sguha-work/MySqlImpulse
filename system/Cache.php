<?php

/**
*This class is following the singleton pattern and is responsible for reading data from cache array
*and writing data to cache array
*/

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
	public function writeToCache( $index = null, $data ) {
	  $serializeData = serialize($data);	
      if( $index == null ) {
      	die("Error:No Index Specified.Unable to write cahce");
      }
      self :: $CacheArray[ $index ] = serialize( $data );
      return true;
	}
	public function getFromCache( $index = null )
	{
      if( $index == null ) {
      	die("Error:No Index Specified.Unable to read from cahce")
      }
      $data = unserialize(self :: $CacheArray[ $index ]);
      return $data;
	}
}
?>