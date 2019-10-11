<?php namespace igaster\EloquentDecorator\Tests\TestCase;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Orchestra\Testbench\TestCase;

class TestCaseWithDatbase extends TestCase
{

    // -----------------------------------------------
    //  Load .env Environment Variables
    // -----------------------------------------------

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (file_exists(__DIR__.'/../.env')) {
            $dotenv = Dotenv::create(__DIR__.'/../');
            $dotenv->load();
        }
    }

    // -----------------------------------------------
    //   Set Laravel App Configuration
    // -----------------------------------------------

    protected function getEnvironmentSetUp($app) {
        $config = $app['config'];

        $config->set('app.debug', 'true');
        $config->set('database.default', 'testbench');
        $config->set('database.connections.testbench', [
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST'),
            'username'  => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
            'database'  => getenv('DB_DATABASE'),
            'port'      => env('DB_PORT', '3306'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => env('DB_STRICT', false),
            'engine'    => null,
        ]);

        $this->pdo = $app['db']->connection()->getPdo();
    }

    // -----------------------------------------------
    //  Setup Database
    // -----------------------------------------------

    protected $database;

    public function setUp(): void
    {
        parent::setUp();

        Eloquent::unguard();
        $database = new DB;
        $database->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
        $database->bootEloquent();
        $database->setAsGlobal();
        $this->database = $database;

        // Add your migrations here. ie:

        // $this->database->schema()->create('TableName', function ($table) {
        //     $table->increments('id');
        // });        
    }

    public function tearDown(): void
    {
        // Drop tables here. ie:
        // $this->database->schema()->drop('TableName');
    }

    // -----------------------------------------------

    public function testDatabaseConnection()
    {
        $this->assertInstanceOf('Illuminate\Database\SQLiteConnection', $this->database->connection());
    }

    // -----------------------------------------------
    //  Added functionality
    // -----------------------------------------------

    protected function seeInDatabase($table, array $data, $connection = null)
    {
        $database = $this->database;

        $count = $database->table($table)->where($data)->count();

        $this->assertGreaterThan(0, $count, sprintf(
            'Unable to find row in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));

        return $this;
    }

    protected function notSeeInDatabase($table, array $data, $connection = null)
    {
        $database = $this->database;

        $count = $database->table($table)->where($data)->count();

        $this->assertEquals(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));

        return $this;
    }
}    