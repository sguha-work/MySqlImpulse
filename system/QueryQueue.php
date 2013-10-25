<?php
/**
*This Queue class holds an array of the executed queries.The isnertion and deletion in 
*the query queue is maintained by the Cache MAnage class
*/
class QueryQueue {
	private $QuesueArray=array();
	private function __construct() {

	}
	public static function getQueryQueueInstance() {
		static $queryQueue_object = NULL;
		if( $queryQueue_object == NULL ) {
			$queryQueue_object = new QueryQueue();
		}
		return $queryQueue_object;
	}
}
?>