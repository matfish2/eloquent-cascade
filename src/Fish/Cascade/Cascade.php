<?php

namespace Fish\Cascade;

trait Cascade {

 public static function bootCascade()
 {
  static::deleting(function ($model) {
    if (property_exists($model, 'cascade') && is_array($model->cascade)) {
      foreach ($model->getCascade() as $relation) {
        if (method_exists($model, $relation)) {
          foreach ($model->{$relation}()->get() as $related)
            $related->delete();
        }
      }
    }
  });
}

protected function getCascade() {
  return $this->cascade;
}

}
