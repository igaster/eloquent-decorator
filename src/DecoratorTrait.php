<?php namespace igaster\EloquentDecorator;

// Add functions to  class without extending it!

/*----------------------------------
 	       Example usage
------------------------------------
	class A {
		public $x=1;
	};

	class B {
		use traitDecorator;

		// add behavior to A here!
		// '$this->object' = 'instance of A'
	};

	$a = new A();
	$b = B::wrap($a); 

	echo $b->x;   // = 1
----------------------------------*/


trait DecoratorTrait {

	public $object;

	// call this to attach the decorator!
	public static function wrap($object){
		$result = new static;
		$result->object = $object;
		return $result;
	}

	public function __call($method, $args) {
	    return call_user_func_array(array($this->object, $method), $args);
	}

	public function __get($key) {
		return $this->object->$key;
	}

	public function __set($key, $value) {
		$this->object->$key = $value;
	}

	public function __isset ($name){
		return isset($this->object->$name); 
	}

}