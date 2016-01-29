<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;
use Fish\Cascade\Cascade;

class BaseModel extends Model
{
    protected $guarded = [];

    public function getDates() {
      return [];
    }


    use Cascade;
}
