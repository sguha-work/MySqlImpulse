<?php

/**
*This class is following the singleton pattern and is responsible for reading data from cache array
*and writing data to cache array
*/

class Cache
{
	private static $CacheArray=array();
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
	public function writeToCache($data, $index = NULL) {
            $serializeData = serialize($data);	
            if(($index == NULL) && ($index != 0)) {
                die("Error:No Index Specified.Unable to write cahce");
            }
            self :: $CacheArray[$index] = $serializeData;
            return true;
	}
	
	/**
	*This function receives the index of the cache array and returns the unserialized data from cache array
	*/
	public function getFromCache($index = NULL)
	{
            if(($index == NULL) && ($index != 0)) {
              die("Error:No Index Specified.Unable to read from cahce");
            }
            $data = unserialize(self :: $CacheArray[$index]);
            return $data;
	}
}
?>