<?php
    return [
        'datetime_format' => 'Y-m-d h:i:s',
        'date_format' => 'd-m-Y',
        'page_length' => 10,
        'list_book_path' => '/admin/books',
        'filter' => [
            \App\Model\Book::DONATED => 'donator',
            \App\Model\Book::BORROWED => 'borrowings',
        ],
        'all' => 'all',
        'date_diff' => 3,
        'timezone' => 7,
        'languages' => [
            'Vietnamese' => 'Vietnamese',
            'Japanese' => 'Japanese',
            'Korean' => 'Korean',
            'English' => 'English',
        ],
        'messages' => [
            '404_not_found' => 'Not Found',
            '405_method_error' => 'Method Failure',
            '500_server_error' => 'Server Error',
            'token_not_found' => 'AccessToken Not Found',
            '440_login_timeout' => 'Login Timeout',
            'error_occurred' => 'Has Error Occurred, Please Try Again'
        ],
        'book' => [
            'item_limit' => 20,
        ],
        'review' => [
            'limit_render' => 20,
        ],
        'time_send_mail' => 14,
        'qrcode' => [
            'begin_prefix_pos' => 0,
            'end_prefix_pos' => 4,
        ],
        'comment' => [
            'limit_render' => 10,
        ],
        'time_in_day_send_mail' => '11:00',
        'time_zone' => 'Asia/Ho_Chi_Minh',
        'post' => [
            'page_length' => 20,
            'delete_success' => 'Delete Post Successful',
            'unauthorized' => 'You are not the owner of this post',
        ],
        'type_post' => [
            \App\Model\Post::REVIEW_TYPE, 
            \App\Model\Post::STATUS_TYPE, 
            \App\Model\Post::FIND_TYPE,       
        ],
    ];
