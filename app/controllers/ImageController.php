<?php

class ImageController extends BaseController {

	public function postUpload()
	{
		if (Input::hasFile('mobileImage'))
		{
		    $file = Input::file('mobileImage');
		    $file->move('uploads', $file->getClientOriginalName());
		 
		    return $file->getClientOriginalName();
		}
	}

	public function postCrop()
	{
		//get filename of the file
		$file 	= Input::get('filename');

		$w 		= Input::get('w');
		$h 		= Input::get('h');
		$x 		= Input::get('x');
		$y 		= Input::get('y');

		//crop image
		Image::make(sprintf('uploads/%s', $file))->crop($w, $h, $x, $y)->save();

		//resize to default
		Image::make(sprintf('uploads/%s', $file))->resize(640, null, function ($constraint) {
		    $constraint->aspectRatio();
		});

		return $file;
	}
}