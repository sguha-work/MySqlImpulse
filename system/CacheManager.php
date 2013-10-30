<?php
//This class is responsible to manage the cahce

class CacheManager
{
	function __construct() {

	}
        /**
         * This function checks wheather the query exits in the query queue or not
         * 
         * 
         */
	public function isQueryExitsInCache($query) {
		$queryQueue_object = $this -> getQueryQueueObject();
        return($queryQueue_object -> isQueryExists($query));
	}
        /**
         * This function receives the query as an argument and checks first
         * wheather the query exits in the query que or not.If the query exits 
         * in the queue the it returnes the cached data else call the setCache(Query)
         * funtciotn
         * 
         */
        public function getCachedData($query) {
            if($this -> isQueryExitsInCache($query) == FALSE){
                return FALSE;
            }

        }
        /**
         * This function save the query into query array and the dataArray to cache
         * 
         * 
         */
        public function saveDataToCache($query, $dataArray) {
            $queryQueueObject = $this -> getQueryQueueObject();
            $index = $queryQueueObject -> insertInQueue($query);
            $cacheObject = $this -> getCacheInstance();
            $cacheObject -> writeToCache($dataArray, $index);
        }
        /**
         * This function returns te data from cache,as an argument it receives
         * the query and returned the array of rows
         * 
         */
        public function getDataFromCache($query) {
            $queryQueueObject = $this -> getQueryQueueObject();
            $index = $queryQueueObject -> insertInQueue($query);
            $cacheObject = $this -> getCacheInstance();
            return $cacheObject -> getFromCache($index);
        }
        /**
         * This function returnes the query queue instance
         * 
         */
	private function getQueryQueueObject() {
		$queryQueue_object = QueryQueue :: getQueryQueueObject();
		return $queryQueue_object;
	}
        /**
         * This function returns the cache instance
         * 
         */
	private function getCacheInstance() {
		$cache_object = Cache :: getCacheObject();
		return $cache_object;
	}
}
?>