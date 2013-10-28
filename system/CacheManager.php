<?php
//This class is responsible to manage the cahce

class CacheManager
{
	function __construct() {

	}
	public function isQueryExitsInCache($query) {
		$queryQueue_object = $this->getQueryQueueInstance();

	}
	private function getQueryQueueInstance() {
		$queryQueue_object = QueryQueue :: getQueryQueueInstance();
		return $queryQueue_object;
	}
	private function getCacheInstance() {
		$cache_object = Cache :: getCacheObject();
		return $cache_object;
	}
}
?>