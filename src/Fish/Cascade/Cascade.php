<?php

namespace Fish\Cascade;

trait Cascade {

 public static function boot()
 {
  static::deleting(function ($model) {
    if (property_exists($model, 'cascade') && is_array($model->cascade)) {
      foreach ($model->cascade as $relation) {
        if (method_exists($model, $relation)) {
          foreach ($model->{$relation}()->get() as $related)
            $related->delete();
        }
      }
    }
  });
}

}
