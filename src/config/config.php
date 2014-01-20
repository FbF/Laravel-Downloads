<?php

return array(

	/**
	 * The path, relative to the public_path() directory, where the downloads are uploaded to.
	 */
	'dir' => '/uploads/packages/fbf/laravel-downloads/downloads/',

	/**
	 * Settings for the image associated with a download
	 */
	'image' => array(

		/**
		 * Settings for the original image uploaded
		 */
		'original' => array(
			/**
			 * The path, relative to the public_path() directory, where the original images are stored.
			 */
			'dir' => '/uploads/packages/fbf/laravel-downloads/images/original/',
		),

		/**
		 * Settings for the different versions automatically resized from the original, on upload
		 */
		'sizes' => array(

			/**
			 * Settings for the version called "resized"
			 */
			'resized' => array(

				/**
				 * The path, relative to the public_path() directory, where the "resized" images are stored.
				 */
				'dir' => '/uploads/packages/fbf/laravel-downloads/images/resized/',

				/**
				 * The width of the "resized" images. The resized version of images will fit within this size
				 */
				'width' => 120,

				/**
				 * The height of the "resized" images. The resized version of images will fit within this size
				 */
				'height' => 90,
			),

		),

	),

);