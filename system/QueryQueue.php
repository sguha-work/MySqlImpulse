<?php
/**
*This Queue class holds an array of the executed queries.The isnertion and deletion in 
*the query queue is maintained by the Cache MAnage class
*/
class QueryQueue {

	//Main Query array
	private static $QueryArray = array();

	//Max queue size
	private static $QueueSize   = 0;
	
	//Front index value through where query will be inserted in queue
	private static $Front       = -1;
	
	//Rear value through where query will be deleted
	private static $Rear        = -1;

	//Index of the lates item which is replaced
	private static $QueueIndex  = -1;
	
	private function __construct() {
		self :: $QueueSize = MAX_CACHE_SIZE;
	}
	
	public static function getQueryQueueInstance() {
		static $queryQueue_object = NULL;
		if( $queryQueue_object == NULL ) {
			$queryQueue_object = new QueryQueue();
		}
		return $queryQueue_object;
	}
	
	/**
	*This functions receives a query as an argument and insert the query in the query array it returned the 
	*index where the query is inserted
	*/
	public function insertInQueue( $query ) {
		if( self :: $Front == -1 && self :: $Rear == -1 && self :: $QueueIndex == -1 ) {
			self :: $Front += 1;
			self :: $Rear  += 1;
			self :: $QueueIndex  += 1;
		}
		$index = 0;
		if( self :: $Front >= self :: $QueueSize ) {
			self :: $QueryArray[ self :: $QueueIndex ] = $query;
			$index = self :: $QueueIndex;
			self :: $QueueIndex += 1;
			if( self :: $QueueIndex >= self :: $QueueSize ) {
				self :: $QueueIndex = 0;
			}
		}
		else {
			self::$QueryArray[self :: $Front] = $query;	
			$index = self :: $Front;
			self :: $Front += 1;
		}
		return $index;
	}

	/**
	*This function receives a query as the argument and checks whether
        *the query exits in queue or not.If exists the function returned
        *the index of the query else return FALSE  
	*/
	public function isQueryExists($inputQuery = NULL) {
		if($inputQuery == NULL) {
			die("Error:No Query specified");
		}
		else {
                        if(self :: $Front == -1 && self :: $Rear == -1 && self :: $QueueIndex == -1)
                            return FALSE;
			$index = 0;
			foreach(self :: $QueryArray as $query) {
				if($query == $inputQuery) {
					return $index;
				}
				$index += 1;
			}
			return FALSE;
		}
	}
}
?>