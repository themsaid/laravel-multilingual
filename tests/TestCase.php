<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestCase extends Orchestra\Testbench\TestCase
{

    protected $DBName = 'laravel_packages_test';
    protected $DBUsername = 'homestead';
    protected $DBPassword = 'secret';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->prepareDatabase();
    }

    public function test_database_setup()
    {
        $this->assertTrue(Schema::hasTable('planets'));
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('multilingual.locales', ['en', 'sp']);
        $app['config']->set('multilingual.fallback_locale', 'en');

        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => $this->DBName,
            'username'  => $this->DBUsername,
            'password'  => $this->DBPassword,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]);
    }

    /**
     * Loading package service provider
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['Themsaid\Multilingual\MultilingualServiceProvider'];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Schema'    => 'Illuminate\Database\Schema\Blueprint'
        ];
    }

    public function prepareDatabase()
    {
        if ( ! Schema::hasTable('planets')) {
            Schema::create('planets', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('order');
            });
        }
    }
}
