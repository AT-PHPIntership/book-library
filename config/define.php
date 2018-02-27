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
    'messages' => [
      '404_not_found' => 'Page Not Found',
      '405_method_error' => 'Method Failure',
      '500_server_error' => 'Server Error',
      'token_not_found' => 'AccessToken Not Found',
      '440_login_timeout' => 'Login Timeout'
    ],
    'book' => [
      'item_limit' => 20,
    ],
    'time_send_mail' => 14
  ];
