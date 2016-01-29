<?php
namespace Models;

class User extends BaseModel
{

    protected $cascade = ['author'];

    public function author() {

      return $this->hasOne(Author::class);

    }
}
