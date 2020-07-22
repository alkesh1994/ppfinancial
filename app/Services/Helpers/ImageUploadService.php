<?php

namespace App\Services\Helpers;

use File;

class ImageUploadService
{

  function handleImageUpload($image,$directory,$oldImage = 0){

    if($oldImage){
      //delete old image if exists
      if(File::exists($oldImage))
      File::delete($oldImage);
    }

    //handle image upload
    $imagePath = "uploads/".$directory."/".time().str_random(10).$image->getClientOriginalName();
    $image->move("uploads/".$directory, $imagePath);

    return $imagePath;

  }

}
