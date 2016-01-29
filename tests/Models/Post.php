<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Post extends BaseModel
{

  protected $cascade = ['comments'];

  public function comments() {

    return $this->hasMany(Comment::class);

  }


}
