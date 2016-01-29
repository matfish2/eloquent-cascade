# Laravel Eloquent Cascading Delete

[![Build Status](https://travis-ci.org/matfish2/eloquent-cascade.svg?branch=master)](https://travis-ci.org/matfish2/eloquent-cascade)

This package offers a simple trait that leverages the Eloquent delete event to recursively delete all specified relations for a given model.

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `fish/eloquent-cascade`.

    "require": {
      "fish/eloquent-cascade": "dev-master"
    }

  Next, update Composer from the Terminal:

    composer update

## Usage

1. Include the trait in a parent model and make the other models extend it:

        namespace App;

        use Illuminate\Database\Eloquent\Model;
        use Fish\Cascade\Cascade;

        class BaseModel extends Model
        {
            use Cascade;
        }

1. Add the relations you wish to delete to a protected `$cascade` array on the model. e.g:

        class User extends BaseModel
        {

            protected $cascade = ['author'];

            public function author() {

              return $this->hasOne(Author::class);

            }
        }

        class Author extends BaseModel
        {

            protected $cascade = ['posts'];

            public function user() {

              return $this->belongsTo(User::class);

            }

            public function posts() {

              return $this->hasMany(Post::class);

            }

        }

        class Post extends BaseModel
        {

          protected $cascade = ['comments'];

          public function comments() {

            return $this->hasMany(Comment::class);

          }

        }


If you are using a trait for polymorphic relations and want to add this relation to the `$cascade` array, override the protected `getCascade` method.
Suppose you have a `Locale` trait:

       trait Locale {

        public function locale() {
            return $this->morphMany(Locale::class, 'translatable');
        }

        protected function getCascade() {
          return array_merge($this->cascade, ['locale']);
        }

       }


