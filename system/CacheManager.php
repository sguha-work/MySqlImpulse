<?php
//This class is responsible to manage the cahce

class CacheManager
{
	function __construct() {

	}
	public function isQueryExitsInCache($query) {
		$queryQueue_object = $this->getQueryQueueInstance();
                return($queryQueue_object->isQueryExists($query));
	}
        /**
         * This function receives the query as an argument and checks first
         * wheather the query exits in the query que or not.If the query exits 
         * in the queue the it returnes the cached data else call the setCache(Query)
         * funtciotn
         * 
         */
        public function getCachedData($query) {
            
        }
        /**
         * This function returnes the query queue instance
         * 
         */
	private function getQueryQueueInstance() {
		$queryQueue_object = QueryQueue :: getQueryQueueInstance();
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