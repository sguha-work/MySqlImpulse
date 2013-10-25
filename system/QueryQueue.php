<?php
/**
*This Queue class holds an array of the executed queries.The isnertion and deletion in 
*the query queue is maintained by the Cache MAnage class
*/
class QueryQueue {
	private $QuesueArray = array();
	private $QueueSize   = 0;
	private $front       = -1;
	private $rear        = -1
	private function __construct() {
		slef :: $QueueSize = MAX_CACHE_SIZE;
	}
	public static function getQueryQueueInstance() {
		static $queryQueue_object = NULL;
		if( $queryQueue_object == NULL ) {
			$queryQueue_object = new QueryQueue();
		}
		return $queryQueue_object;
	}
	public function inserInQueue( $query ) {
		if( self::$front == self::$rear == -1 ) {
			self::$front += 1;
			self::$rear  += 1;
		}
		$index = 0;
		if( self::$front >= self::$QueueSize ) {
			self::$QuesueArray[$index] = $query;
		}
		else {
			self::$front += 1;
			self::$QuesueArray[self::$front] = $query;	
			$index = self::$front;
		}
		return $index;
	}

}
?>