<?php
  return [
    'datetime_format' => 'Y-m-d h:i:s',
    'page_length' => 10,
    'filter' => [
      \App\Model\Book::DONATED => 'donator',
      \App\Model\Book::BORROWED => 'borrowings',
    ],
  ];
