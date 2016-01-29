<?php

use Orchestra\Testbench\TestCase;
use Models\User;
use Models\Author;
use Models\Post;
use Models\Comment;

class CascadeTest extends TestCase
{

   /**
   * Setup the test environment.
   */
    public function setUp()
    {
        parent::setUp();

        // Create an artisan object for calling migrations
        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        // Call migrations specific to our tests, e.g. to seed the db
        $artisan->call('migrate', array(
            '--database' => 'testbench',
            '--path'     => '../tests/database/migrations',
        ));

    }

    /**
   * Define environment setup.
   *
   * @param  Illuminate\Foundation\Application    $app
   * @return void
   */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__ . '/../src';

        // set up database configuration
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
        ));

    }


    /** @test */
    public function it_deletes_all_specified_relations()
    {

        $user = User::create([]);
        $author = Author::create(['user_id'=>$user->id]);
        $post = Post::create(['author_id'=>$author->id]);
        $comment = Comment::create(['post_id'=>$post->id]);

        $user = $user->fresh();

        $this->assertEquals($user->author()->count(), 1,'author');
        $this->assertEquals($user->author()->first()->posts()->count(), 1,'posts');
        $this->assertEquals($user->author()->first()->posts()->first()->comments()->count(), 1,'comments');

        $user->delete();

        $this->assertEquals(Post::where('author_id',1)->count(), 0, 'post 0');
        $this->assertEquals(Comment::where('post_id',1)->count(), 0, 'comment 0');
        $this->assertEquals(Author::where('user_id',1)->count(), 0, 'user 0');

    }
}
