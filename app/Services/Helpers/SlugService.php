<?php

namespace App\Services\Helpers;

class SlugService
{

  public function createSlug($model,$sluggableField, $id = 0)
  {
    $slug = str_slug($sluggableField);

    $allSlugs = $this->getRelatedSlugs($model,$slug, $id);

    if (! $allSlugs->contains('slug', $slug)){
      return $slug;
    }

    for ($i = 1; $i <= 10; $i++) {
      $newSlug = $slug.'-'.$i;
      if (! $allSlugs->contains('slug', $newSlug)) {
        return $newSlug;
      }
    }

    throw new \Exception('Can not create a unique slug');
  }

  protected function getRelatedSlugs($model,$slug, $id = 0)
  {
    $modelNamespace = config('global.model_namespace').$model;
    return $modelNamespace::select('slug')->where('slug', 'like', $slug.'%')->where('id', '<>', $id)->get();
  }

}
