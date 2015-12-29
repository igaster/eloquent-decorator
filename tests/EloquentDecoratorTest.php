<?php

use igaster\EloquentDecorator\Test\Models\Article;
use igaster\EloquentDecorator\Test\Models\ArticleDecorator;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EloquentDecoratorTest extends Orchestra\Testbench\TestCase
{
    use Illuminate\Foundation\Testing\DatabaseTransactions;

    // -----------------------------------------------
    //  Load .env Environment Variables
    // -----------------------------------------------

    public static function setUpBeforeClass()
    {
        if (file_exists(__DIR__.'/../.env')) {
            $dotenv = new Dotenv\Dotenv(__DIR__.'/../');
            $dotenv->load();
        }
    }

    // -----------------------------------------------
    //  Setup Database
    // -----------------------------------------------

    protected $db;
    public function setUp()
    {
        parent::setUp();

        Eloquent::unguard();
        $db = new DB;
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $db->bootEloquent();
        $db->setAsGlobal();
        $this->db=$db;

        // -- Set  migrations
        $db->schema()->create('articles', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('body');
            $table->timestamps();
        });
    }

    public function tearDown() {
        $this->db->schema()->drop('articles');
    }

    // -----------------------------------------------

    public function test_eloquent_decorator(){

        // Set original Object
    	$original = Article::create([
    		'title' => 'One',
    		'body'	=> 'Body',
    	]);

        // Decorete it
    	$original = Article::find($original->id);
    	$decorated = ArticleDecorator::wrap($original);

        // Decoretor can access attributes on original object
		$this->assertEquals($original->title, 'One');
		$this->assertEquals($decorated->title, 'One');

        // Set value on original
        $original->title = 'Two';
        $this->assertEquals($decorated->title, 'Two');

        // Set value on decorated
        $decorated->title='Three';
        $this->assertEquals($decorated->title, 'Three');

        // Save in Database (from the decorated)
        $decorated->title='Four';
        $decorated->body='Five';
        $decorated->author='Giannis';
        $decorated->save();

        $original = Article::find($original->id);

        // Update attribute on original Object
        $this->assertEquals($original->title, 'Four');
        $this->assertEquals($decorated->title, 'Four');

        // Don't update overriden attribute on original object
        $this->assertEquals($original->body, 'Body');
        $this->assertEquals($decorated->body, 'Five');

        // Array access
        $this->assertEquals($decorated['title'], 'Four');

        // Array access
        $this->assertEquals($decorated['title'], 'Four');

    }

}