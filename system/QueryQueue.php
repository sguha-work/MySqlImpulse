<?php
/**
*This Queue class holds an array of the executed queries.The isnertion and deletion in 
*the query queue is maintained by the Cache MAnage class
*/
class QueryQueue {

	//Main Query array
	private $QueryArray = array();

	//Max queue size
	private $QueueSize   = 0;
	
	//Front index value through where query will be inserted in queue
	private $Front       = -1;
	
	//Rear value through where query will be deleted
	private $Rear        = -1;

	//Index of the lates item which is replaced
	private $QueueIndex  = -1;
	
	private function __construct() {
		$this -> QueueSize = MAX_CACHE_SIZE;
	}
	
	public static function getQueryQueueObject() {
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
		if( $this -> Front == -1 && $this ->  Rear == -1 && $this ->  QueueIndex == -1 ) {
			$this -> Front += 1;
			$this -> Rear  += 1;
			$this -> QueueIndex  += 1;
		}
		$index = 0;
		if( $this -> Front >= $this -> QueueSize ) {
			$this -> QueryArray[ $this -> QueueIndex ] = $query;
			$index = $this -> QueueIndex;
			$this -> QueueIndex += 1;
			if( $this -> QueueIndex >= $this -> QueueSize ) {
				$this -> QueueIndex = 0;
			}
		}
		else {
			$this -> QueryArray[$this -> Front] = $query;	
			$index = $this -> Front;
			$this -> Front += 1;
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
            if($this -> Front == -1 && $this -> Rear == -1 && $this -> QueueIndex == -1)
                return FALSE;
			$index = 0;
			foreach($this -> QueryArray as $query) {
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