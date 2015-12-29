## Description
[![Laravel](https://img.shields.io/badge/Laravel-5.x-orange.svg)](http://laravel.com)
[![Downloads](https://img.shields.io/packagist/dt/igaster/eloquent-decorator.svg)](https://packagist.org/packages/igaster/eloquent-decorator)
[![Build Status](https://travis-ci.org/igaster/eloquent-decorator.svg?branch=master)](https://travis-ci.org/igaster/eloquent-decorator)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg)](https://tldrlegal.com/license/mit-license)

A simple Trait that implements the Decorator pattern on Laravel eloquent models.

## Usage:

* Extend a model without inheritance (Composition vs Inheritance)
* Create multiple variations of a model

## Example case study:

You often need multiple versions of each Image. Your base model (Image) handles Database, Relations etc.

Your decorated models (ie thumbnail, profileImage) may apply image manipulations to the original image to create variations. ie they can overide the src() method of the base class to point to a different file. All your decorated versions share the same record in the Database but my alter their representation/behavior!

More ideas:

* Base model: `User`. Decorated Objects: Member, Moderator, SuperUser etc
* Base model: `Article`. Decorated Objects: FeaturedArticle, BlogPost, 


## Installation

Edit your project's `composer.json` file to require:

    "require": {
        "igaster/eloquent-decorator": "~1.0"
    }

and install with `composer update

## Implement the Decorator Pattern

1. Class Decleration:

Your class should implement some interfaces to mimic the behavior of Eloquent models:

```php
use igaster\EloquentDecorator\EloquentDecoratorTrait;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;
use ArrayAccess;
use JsonSerializable;

class SuperUser implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    use EloquentDecoratorTrait;

    public $newProperty;		// Add a new property
    public $overridenPropery;	// or Overide a property (it hides it)

    public function TruncateDatabase(){
    	// add your functions...
    }
}
```

2. Decorating an Eloquent model:

```php
	$user = User::find(1);

	$superUser = SuperUser::wrap($user);

	// you can think the SuperUser class as inhereted from the User model. so you can still do:

	$superUser->name = "Admin";
	$superUser->save();

	// But you also have access to SuperUser functions/attributes:

	$superUser->TruncateDatabase();

	// You can always access to the original (decorated object):
	$superUser->object->someProperty;
}
```

3. Need a constructor?

You have to override `EloquentDecoratorTrait` and create your own factory function. Dont forget to call `self::wrap($object)` at the end.
