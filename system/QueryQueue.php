<?php
/**
*This Queue class holds an array of the executed queries.The isnertion and deletion in 
*the query queue is maintained by the Cache MAnage class
*/
class QueryQueue {
	private $QuesueArray = array();//Main Query array
	private $QueueSize   = 0;//Max queue size
	private $Front       = -1;//Front index value through where query will be inserted in queue
	private $Rear        = -1;//Rear value through where query will be deleted
	private $QueueIndex  = -1;//Index of the lates item which is replaced
	
	private function __construct() {
		slef::$QueueSize = MAX_CACHE_SIZE;
	}
	
	public static function getQueryQueueInstance() {
		static $queryQueue_object = NULL;
		if( $queryQueue_object == NULL ) {
			$queryQueue_object = new QueryQueue();
		}
		return $queryQueue_object;
	}
	
	public function insertInQueue( $query ) {
		if( self::$Front == self::$Rear == self::$Rear -1 ) {
			self::$Front += 1;
			self::$Rear  += 1;
			self::$QueueIndex  += 1;
		}
		if( self::$Front >= self::$QueueSize ) {
			self::$QuesueArray[ self::$QueueIndex ] = $query;
			self::$QueueIndex += 1;
			if( self::$QueueIndex >= self::$QueueSize ) {
				self::$QueueIndex = 0;
			}
		}
		else {
			self::$QuesueArray[self::$Front] = $query;	
			self::$Front += 1;
		}
		return $index;
	}

}
?>