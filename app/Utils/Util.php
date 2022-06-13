<?php

namespace App\Utils;

use Image;

class Util
{
  public function uploadFile($request)
  {
    // $fileName = Image::make($request->getRealPath());
    // $fileName->resize(100, 100, function ($constraint) {
    //   $constraint->aspectRatio();
    // });
    $fileName = time() . '.' . $request->extension();
    $request->move(public_path('uploads'), $fileName);
    return asset("uploads/$fileName");
  }
  public function unlinkFile($file_url)
  {
    $file = basename($file_url);
    if (file_exists(public_path("uploads/$file"))) {
      unlink(public_path("uploads/$file"));
    }
    return true;
  }
}
