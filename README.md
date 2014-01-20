Laravel Downloads
=================

A Laravel 4 package for adding content managed 'downloads' to a site

## Includes

* Migration for a database table to store references to the uploaded files
* Model for accessing the database table
* FrozenNode Administrator config for uploading and managing images

## Installation

Add the following to you composer.json file

    "fbf/laravel-downloads": "dev-master"

Run

    composer update

Add the following to app/config/app.php

    'Fbf\LaravelDownloads\LaravelDownloadsServiceProvider'

Publish the config

    php artisan config:publish fbf/laravel-downloads

Run the migration

    php artisan migrate --package="fbf/laravel-downloads"

Create the relevant image upload directories that you specify in your config, e.g.

    public/uploads/packages/fbf/laravel-downloads/downloads
    public/uploads/packages/fbf/laravel-downloads/images/original
    public/uploads/packages/fbf/laravel-downloads/images/resized

## Usage

In your views you can do something like the following:

```html
<p class="download--{{ strtolower($download->extension) }}">
    <a href="{{ $download->getRelativePath() }}" title="{{ $download->title }}">
        <img src="{{ $download->getImageRelativePath('resized') }}" alt="{{ $download->title }}" width="{{ $download->getImageWidth('resized') }}" height="{{ $download->getImageHeight('resized') }}" />
        Download our {{ $download->title }}
    </a>
    [{{ $download->extension }}, {{ $download->human_readable_filesize }}]
</p>
```

## Administrator

You can use the excellent Laravel Administrator package by frozennode to administer your images.

http://administrator.frozennode.com/docs/installation

A ready-to-use model config file for the Download model (downloads.php) is provided in the src/config/administrator directory of the package, which you can copy into the app/config/administrator directory (or whatever you set as the model_config_path in the administrator config file).