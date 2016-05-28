<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Media Thumbnail sizes
      |--------------------------------------------------------------------------
     */

    'thumbnails' => true,

    'sizes' => array(
        'medium' => array(460, 307),
        'small' => array(234, 156),
        'thumbnail' => array(165, 108),
        'free' => array(725, 300)
        
    ),

    /*
      |--------------------------------------------------------------------------
      | Allowed file types
      |--------------------------------------------------------------------------
     */

    "allowed_file_types" => 'jpg,png,jpeg,gif,doc,docx,txt,pdf,zip',

    /*
      |--------------------------------------------------------------------------
      | Max file size to upload in KB
      |--------------------------------------------------------------------------
     */

    "max_file_size" => 3072,

    /*
      |--------------------------------------------------------------------------
      | Maximium image width in px
      | if uploaded image exceeds max width, set it as max width
      |--------------------------------------------------------------------------
     */

    "max_width" => 1200,

    /*
      |--------------------------------------------------------------------------
      | S3 configuration
      |--------------------------------------------------------------------------
     */

    "s3" => [

        /*
          |--------------------------------------------------------------------------
          | Allow uploading to S3
          |--------------------------------------------------------------------------
         */

        "status" => false,
        'bucket' => "dotemirates",
        'region' => "eu-west-1",

        /*
          |--------------------------------------------------------------------------
          | Delete file after uploading to S3
          |--------------------------------------------------------------------------
         */

        "delete_locally" => false
    ],


    "permissions" => [
        "manage_captions",
        "watermarking",
        "cropping"
    ],


    "providers" => [
        Intervention\Image\ImageServiceProvider::class,
        Aws\Laravel\AwsServiceProvider::class,
    ],

    "aliases" => [
        'Image' => Intervention\Image\Facades\Image::class,
        'AWS' => Aws\Laravel\AwsFacade::class,
    ]
];
