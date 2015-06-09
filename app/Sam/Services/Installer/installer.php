<?php namespace Sam\Services\Installer;

use File, Input, Hash;

class Installer
{

	private $file;
	private $ext;
	private $original_filename;
	private $allowed_extensions = array('zip');

	public function getPackage()
	{
		if ($this->isPackageVerified())
		{
			return $this;
		}

		trigger_error('package is invalid');
	}

	public function isPackageVerified()
	{
		if(Input::hasFile('package'))
		{
			$this->file = Input::file('package');
			$this->ext = Input::file('package')->getClientOriginalExtension();
			$this->original_filename = Input::file('package')->getClientOriginalName();

			return in_array($this->ext, $this->allowed_extensions) ? true : false;
		}
		
		return false;
	}

	public function uploadBackend()
	{
		$destination = app_path() . '/modules';
		$filename = $this->original_filename;
		$this->file->move($destination, $filename);

		$new_path = $destination . '/' . $filename;

		$this->extractTo($new_path, $destination);

		return $this;
	}

	public function uploadFrontend()
	{
		$destination = public_path() . '/packages';
		$filename = $this->original_filename;

		$this->file->move($destination, $filename);

		return $this;
	}

	public function extractTo($file, $destination)
	{
		$zipper = new \Chumper\Zipper\Zipper;
		$zipper->make($file)->extractTo($destination);
		
		unlink($file);

		return true;
	}
}