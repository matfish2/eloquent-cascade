<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

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
