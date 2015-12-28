<?php

use Orchestra\Testbench\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use igaster\EloquentDecorator\EloquentDecoratorTrait;
use igaster\EloquentDecorator\DecoratorTrait;

// ------------- Decorator Helper Clases ------------------

class Foo{
	public 		$a1=10;
	public 		$a2=11;
	protected 	$a3=12;
	private 	$a4=13;
	
	public function fooFunction(){
		return 14;
	}
}

class Bar{
	use DecoratorTrait;
	public $b=20;
	public $a2=22;
}

// -----------------------------------------------

class DecoratorTest extends TestCase
{
    public function test_decorator(){
    	$foo = new Foo();
    	$bar = Bar::wrap($foo);

    	// internal object
		$this->assertEquals($foo, $bar->object);
		
		// original property
		$this->assertEquals($bar->a1, 10);
		
		// new property
		$this->assertEquals($bar->b,  20);

		// redifine original property		
		$this->assertEquals($bar->a2, 22);

		// original function
		$this->assertEquals($bar->fooFunction(), 14);

		// isset 
		$this->assertTrue(isset($bar->b));
		$this->assertTrue(isset($bar->a1));
    }
}