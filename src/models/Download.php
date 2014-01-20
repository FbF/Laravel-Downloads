<?php namespace Fbf\LaravelDownloads;

class Download extends \Eloquent {

	/**
	 * Name of the table to use for this model
	 * @var string
	 */
	protected $table = 'fbf_downloads';

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::saving(function(\Eloquent $model)
		{
			// If a new download file is uploaded, could be create or edit...
			$dirty = $model->getDirty();
			if (array_key_exists('filename', $dirty))
			{
				$file = new \SplFileInfo($model->getAbsolutePath());
				$model->filesize = $file->getSize();
				$model->extension = strtoupper($file->getExtension());
				// Now if editing only...
				if ($model->exists)
				{
					$oldFilename = self::where($model->getKeyName(),'=',$model->id)->first()->pluck('filename');
					$newFilename = $dirty['filename'];
					// Delete the old file if the filename is different to the new one, and it therefore hasn't been replaced
					if ($oldFilename != $newFilename)
					{
						$model->deleteFile($oldFilename);
					}
				}
			}
		});

		static::deleted(function($model)
		{
			$model->deleteFile();
		});
	}

	/**
	 * Returns the path, relative to public_path(), for the given filename. If filename is not passed, use the
	 * current record's filename.
	 *
	 * @param string $filename
	 * @return string
	 */
	public function getRelativePath($filename = null)
	{
		if (is_null($filename))
		{
			$filename = $this->filename;
		}
		return \Config::get("laravel-downloads::dir") . $filename;
	}

	/**
	 * Returns the absolute path on the server to the file for the given filename. If filename is not passed, use the
	 * current record's filename.
	 *
	 * @param string $filename
	 * @return string
	 */
	public function getAbsolutePath($filename = null)
	{
		return public_path($this->getRelativePath($filename));
	}

	/**
	 * Deletes the file for the given filename. If filename is not passed, use the current record's filename.
	 *
	 * @param string $filename
	 */
	protected function deleteFile($filename = null)
	{
		unlink($this->getAbsolutePath($filename));
	}

	/**
	 * Accessor for human readable filesize
	 *
	 * @return string
	 */
	public function getHumanReadableFilesizeAttribute()
	{
		$filesize = $this->getAttribute('filesize');
		return $this->getHumanReadableSize($filesize);
	}

	/**
	 * Returns the given size in bytes as human readable string with units. Don't pass in units and it will
	 * automatically select the most appropriate.
	 *
	 * @param $size
	 * @param null $unit
	 * @param int $decimals
	 * @return string
	 */
	public function getHumanReadableSize($size, $unit = null, $decimals = 1) {
		$byteUnits = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
		if (!is_null($unit) && !in_array($unit, $byteUnits)) {
			$unit = null;
		}
		$extent = 1;
		foreach ($byteUnits as $rank) {
			if ((is_null($unit) && ($size < $extent <<= 10)) || ($rank == $unit)) {
				break;
			}
		}
		return number_format($size / ($extent >> 10), $decimals) . $rank;
	}

	/**
	 * Returns the width of the image according to the config file
	 *
	 * @param $type
	 * @return integer
	 */
	public function getImageWidth($type = 'resized')
	{
		if ($type == 'original')
		{
			list($width) = getimagesize($this->getImageAbsolutePath($type));
			return $width;
		}

		return \Config::get('laravel-downloads::image.sizes.' . $type . '.width');
	}

	/**
	 * Returns the height of the image according to the config file
	 *
	 * @param $type
	 * @return integer
	 */
	public function getImageHeight($type = 'resized')
	{
		if ($type == 'original')
		{
			list(, $height) = getimagesize($this->getImageAbsolutePath($type));
			return $height;
		}

		return \Config::get('laravel-downloads::image.sizes.' . $type . '.height');
	}

	/**
	 * Returns the path, relative to public_path(), for the given type and filename. If filename is not passed, use the
	 * current record's filename. If the the type is not supplied, assume it the original that is wanted.
	 *
	 * @param string $type
	 * @param null $imageFilename
	 * @internal param string $filename
	 * @return string
	 */
	public function getImageRelativePath($type = 'original', $imageFilename = null)
	{
		if ($type != 'original')
		{
			$type = 'sizes.'.$type;
		}
		if (is_null($imageFilename))
		{
			$imageFilename = $this->image;
		}
		return \Config::get("laravel-downloads::image.$type.dir") . $imageFilename;
	}

	/**
	 * Returns the absolute path on the server to the file for the given type and filename. If the the type is not
	 * supplied, assume it the original that is wanted.
	 *
	 * @param string $type
	 * @param null $imageFilename
	 * @internal param string $filename
	 * @return string
	 */
	public function getImageAbsolutePath($type = 'original', $imageFilename = null)
	{
		return public_path($this->getRelativePath($type, $imageFilename));
	}

}