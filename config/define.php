<?php
  return [
    'datetime_format' => 'Y-m-d h:i:s',
    'date_format' => 'd-m-Y',
    'page_length' => 10,
    'filter' => [
      \App\Model\Book::DONATED => 'donator',
      \App\Model\Book::BORROWED => 'borrowings',
    ],
    'all' => 'all',
  ];
