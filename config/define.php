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
    'book' => [
      'item_limit' => 20,
    ]
  ];
