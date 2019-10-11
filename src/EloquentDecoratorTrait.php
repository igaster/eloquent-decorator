<?php namespace igaster\EloquentDecorator;
/* 

Implements Eloquent\Model interfaces

Class declaration should:
	implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable

Add in use section:

	use ArrayAccess;
	use JsonSerializable;
	use Illuminate\Contracts\Support\Jsonable;
	use Illuminate\Contracts\Support\Arrayable;
	use Illuminate\Contracts\Routing\UrlRoutable;
	use Illuminate\Contracts\Queue\QueueableEntity;

*/


trait EloquentDecoratorTrait {

	use DecoratorTrait;

	// ------------------------------------------------------------
	// Enable property mutators: getXxxxxAttribute / setXxxxxAttribute
	// ------------------------------------------------------------

	// public function __get($key) {

	// 	if (method_exists($this, $methodName = 'get'.studly_case($key).'Attribute'))
	// 		return $this->$methodName($this->object->$key);

	// 	return $this->object->$key;
	// }

	// ------------------------------------------------------------
	// Arrayable interface
	// ------------------------------------------------------------

	public function toArray() {
		return $this->object->toArray();
	}

	// ------------------------------------------------------------
	// ArrayAccess interface
	// ------------------------------------------------------------

	public function offsetExists( $offset )	{
		return $this->object->offsetExists ( $offset );
	}

	public function offsetGet( $offset )	{
		return $this->object->offsetGet ( $offset );
	}

	public function offsetSet( $offset , $value )	{
		return $this->object->offsetSet ( $offset , $value );
	}

	public function offsetUnset( $offset )	{
		return $this->object->offsetUnset ( $offset );
	}

	// ------------------------------------------------------------
	// JsonSerializable interface
	// ------------------------------------------------------------

	public function jsonSerialize(){
		return $this->object->jsonSerialize();
	}

	// ------------------------------------------------------------
	// Jsonable interface
	// ------------------------------------------------------------

	public function toJson($options = 0){
		return $this->object->toJson($options);
	}

	// ------------------------------------------------------------
	// QueueableEntity interface
	// ------------------------------------------------------------

	public function getQueueableId(){
		return $this->object->getQueueableId();
	}

    public function getQueueableConnection(){
    	return $this->object->getQueueableConnection();
    }

	public function getQueueableRelations(){
		return $this->object->getQueueableRelations();
	}

	// ------------------------------------------------------------
	// UrlRoutable interface
	// ------------------------------------------------------------

    public function getRouteKey(){
		return $this->object->getRouteKey();
    }

    public function getRouteKeyName(){
		return $this->object->getRouteKeyName();
    }

    public function resolveRouteBinding($value){
		return $this->object->resolveRouteBinding($value);
    }

}
