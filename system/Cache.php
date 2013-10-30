<?php

/**
*This class is following the singleton pattern and is responsible for reading data from cache array
*and writing data to cache array
*/

class Cache
{
	private $CacheArray=array();
	private function __construct() {

	}

	/**
	*This function returns the Cahce object
	*/
	public static function getCacheObject() {
		static $cache_object = NULL;
		if( $cache_object == NULL ) {
			$cache_object = new Cache();
		}
		return $cache_object;
	}
	
	/**
	*This function receives the index and data as argument and stored the data to the given index of 
	*proper index after making the data serialize
	*/
	public function writeToCache($data, $index) {
            $serializeData = serialize($data);	
            $this -> CacheArray[$index] = $serializeData;
            return true;
	}
	
	/**
	*This function receives the index of the cache array and returns the unserialized data from cache array
	*/
	public function getFromCache($index)	{
            $data = unserialize($this -> CacheArray[$index]);
            return $data;
	}
}
?>