<?php

return array(

	/**
	 * Model title
	 *
	 * @type string
	 */
	'title' => 'Downloads',

	/**
	 * The singular name of your model
	 *
	 * @type string
	 */
	'single' => 'download',

	/**
	 * The class name of the Eloquent model that this config represents
	 *
	 * @type string
	 */
	'model' => 'Fbf\LaravelDownloads\Download',

	/**
	 * The columns array
	 *
	 * @type array
	 */
	'columns' => array(
		'filename' => array(
			'title' => 'Download URL',
			'output' => '<a href="' . Config::get('laravel-downloads::dir') . '(:value)" title="' . Config::get('laravel-downloads::dir') . '(:value)" target="_blank"><nowrap style="font-size:50%">' . Config::get('laravel-downloads::dir') . '(:value)</nowrap></a>',
		),
		'title' => array(
			'title' => 'Title'
		),
		'internal_ref' => array(
			'title' => 'Internal Reference'
		),
		'extension' => array(
			'title' => 'Extension'
		),
		'human_readable_filesize' => array(
			'title' => 'Filesize',
			'sort_field' => 'filesize',
		),
	),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'filename' => array(
			'title' => 'Download',
			'type' => 'file',
			'naming' => 'keep',
			'location' => public_path() . Config::get('laravel-downloads::dir'),
			'size_limit' => 20,
		),
		'extension' => array(
			'title' => 'Extension',
			'type' => 'text',
			'editable' => false,
			'visible' => function($model)
				{
					return $model->exists;
				},
		),
		'filesize' => array(
			'title' => 'Filesize',
			'type' => 'text',
			'editable' => false,
			'visible' => function($model)
				{
					return $model->exists;
				},
		),
		'internal_ref' => array(
			'title' => 'Internal Reference (helps you find this download again in future)',
			'type' => 'textarea',
		),
		'title' => array(
			'title' => 'Title (e.g. "Corporate brochure")',
			'type' => 'textarea',
		),
		'image' => array(
			'title' => 'Image',
			'type' => 'image',
			'naming' => 'random',
			'length' => 20,
			'location' => public_path() . Config::get('laravel-downloads::image.original.dir'),
			'size_limit' => 5,
			'sizes' => array(
				array(
					Config::get('laravel-downloads::image.sizes.resized.width'),
					Config::get('laravel-downloads::image.sizes.resized.height'),
					'crop',
					public_path() . Config::get('laravel-downloads::image.sizes.resized.dir'),
					100
				),
			),
		),
		'created_at' => array(
			'title' => 'Created',
			'type' => 'datetime',
			'editable' => false,
		),
		'updated_at' => array(
			'title' => 'Updated',
			'type' => 'datetime',
			'editable' => false,
		),
	),

	/**
	 * The filter fields
	 *
	 * @type array
	 */
	'filters' => array(
		'title' => array(
			'title' => 'Link Title',
			'type' => 'text',
		),
		'internal_ref' => array(
			'title' => 'Internal Reference',
			'type' => 'text',
		),
		'extension' => array(
			'title' => 'Extension',
			'type' => 'text',
		),
		'created_at' => array(
			'title' => 'Created Date',
			'type' => 'date',
		),
		'updated_at' => array(
			'title' => 'Updated Date',
			'type' => 'date',
		),
	),

	/**
	 * The width of the model's edit form
	 *
	 * @type int
	 */
	'form_width' => 300,

	/**
	 * The validation rules for the form, based on the Laravel validation class
	 *
	 * @type array
	 */
	'rules' => array(
		'filename' => 'required',
		'title' => 'max:255',
		'internal_ref' => 'max:255',
		'image' => 'image',
	),

	/**
	 * The sort options for a model
	 *
	 * @type array
	 */
	'sort' => array(
		'field' => 'updated_at',
		'direction' => 'desc',
	),

	/**
	 * If provided, this is run to construct the front-end link for your model
	 *
	 * @type function
	 */
	'link' => function($model)
		{
			return $model->getRelativePath();
		},

);