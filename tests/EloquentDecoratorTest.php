<?php

use Orchestra\Testbench\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use igaster\EloquentDecorator\EloquentDecoratorTrait;
use igaster\EloquentDecorator\DecoratorTrait;

// ------------- EloquentDecorator Helper Clases ------------------

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

use gaster\EloquentDecorator\Test\Models\Article;

class ArticleDecorator 
implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
	use EloquentDecoratorTrait;
}

// -----------------------------------------------

class EloquentDecoratorTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        // Run Test Migrations
        $this->artisan('migrate', [
            // '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
    }

    public function test_eloquent_decorator(){
    	$original = Article::create([
    		'title' => 'Title 1',
    		'body'	=> 'Body 1',
    	]);

    	$original = Article::find($original->id);
    	$decorated = ArticleDecorator::wrap($original);

		$this->assertEquals($original->title, 'Title 1');
		$this->assertEquals($decorated->title, 'Title 1');
    }

}