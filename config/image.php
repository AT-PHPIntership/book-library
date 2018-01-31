<?php
return [
    'max_upload_size'  => '10240',
    'name_prefix'      => date('Y-m-d'),
    'books'            => [
        'upload_path'  => 'images/books',
        'default_path' => 'images/books/default',
        'no_image_name'=> 'no-image.png',
        'storage'      => 'storage/',
    ],
    'users' => [
        'path_upload'  => 'images/users/',
    ],
    'posts' => [
        'path_upload'  => 'images/posts/',
    ],
];
