<?php namespace igaster\EloquentDecorator\Tests\Models;

// ------------- EloquentDecorator Helper Clases ------------------

use igaster\EloquentDecorator\EloquentDecoratorTrait;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;
use ArrayAccess;
use JsonSerializable;

class ArticleDecorator implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    use EloquentDecoratorTrait;

    public $author;	// Add a new property
    public $body;	// Overide a property (hides it)
}
