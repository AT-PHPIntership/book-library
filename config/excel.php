<?php

return array(

    'cache'      => [

        /*
        |--------------------------------------------------------------------------
        | Enable/Disable cell caching
        |--------------------------------------------------------------------------
        */
        'enable'   => true,

        /*
        |--------------------------------------------------------------------------
        | Caching driver
        |--------------------------------------------------------------------------
        |
        | Set the caching driver
        |
        | Available methods:
        | memory|gzip|serialized|igbinary|discISAM|apc|memcache|temp|wincache|sqlite|sqlite3
        |
        */
        'driver'   => 'memory',

        /*
        |--------------------------------------------------------------------------
        | Cache settings
        |--------------------------------------------------------------------------
        */
        'settings' => [

            'memoryCacheSize' => '32MB',
            'cacheTime'       => 600

        ],

        /*
        |--------------------------------------------------------------------------
        | Memcache settings
        |--------------------------------------------------------------------------
        */
        'memcache' => [

            'host' => 'localhost',
            'port' => 11211,

        ],

        /*
        |--------------------------------------------------------------------------
        | Cache dir (for discISAM)
        |--------------------------------------------------------------------------
        */

        'dir'      => storage_path('cache')
    ],

    'properties' => [
        'creator'        => 'Maatwebsite',
        'lastModifiedBy' => 'Maatwebsite',
        'title'          => 'Spreadsheet',
        'description'    => 'Default spreadsheet export',
        'subject'        => 'Spreadsheet export',
        'keywords'       => 'maatwebsite, excel, export',
        'category'       => 'Excel',
        'manager'        => 'Maatwebsite',
        'company'        => 'Maatwebsite',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sheets settings
    |--------------------------------------------------------------------------
    */
    'sheets'     => [

        /*
        |--------------------------------------------------------------------------
        | Default page setup
        |--------------------------------------------------------------------------
        */
        'pageSetup' => [
            'orientation'           => 'portrait',
            'paperSize'             => '9',
            'scale'                 => '100',
            'fitToPage'             => false,
            'fitToHeight'           => true,
            'fitToWidth'            => true,
            'columnsToRepeatAtLeft' => ['', ''],
            'rowsToRepeatAtTop'     => [0, 0],
            'horizontalCentered'    => false,
            'verticalCentered'      => false,
            'printArea'             => null,
            'firstPageNumber'       => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Creator
    |--------------------------------------------------------------------------
    |
    | The default creator of a new Excel file
    |
    */

    'creator'    => 'Maatwebsite',

    'csv'        => [
        /*
       |--------------------------------------------------------------------------
       | Delimiter
       |--------------------------------------------------------------------------
       |
       | The default delimiter which will be used to read out a CSV file
       |
       */

        'delimiter'   => ',',

        /*
        |--------------------------------------------------------------------------
        | Enclosure
        |--------------------------------------------------------------------------
        */

        'enclosure'   => '"',

        /*
        |--------------------------------------------------------------------------
        | Line endings
        |--------------------------------------------------------------------------
        */

        'line_ending' => "\r\n",

        /*
        |--------------------------------------------------------------------------
        | setUseBom
        |--------------------------------------------------------------------------
        */

        'use_bom' => false
    ],

    'export'     => [

        /*
        |--------------------------------------------------------------------------
        | Autosize columns
        |--------------------------------------------------------------------------
        |
        | Disable/enable column autosize or set the autosizing for
        | an array of columns ( array('A', 'B') )
        |
        */
        'autosize'                    => true,

        /*
        |--------------------------------------------------------------------------
        | Autosize method
        |--------------------------------------------------------------------------
        |
        | --> PHPExcel_Shared_Font::AUTOSIZE_METHOD_APPROX
        | The default is based on an estimate, which does its calculation based
        | on the number of characters in the cell value (applying any calculation
        | and format mask, and allowing for wordwrap and rotation) and with an
        | "arbitrary" adjustment based on the font (Arial, Calibri or Verdana,
        | defaulting to Calibri if any other font is used) and a proportional
        | adjustment for the font size.
        |
        | --> PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT
        | The second method is more accurate, based on actual style formatting as
        | well (bold, italic, etc), and is calculated by generating a gd2 imagettf
        | bounding box and using its dimensions to determine the size; but this
        | method is significantly slower, and its accuracy is still dependent on
        | having the appropriate fonts installed.
        |
        */
        'autosize-method'             => PHPExcel_Shared_Font::AUTOSIZE_METHOD_APPROX,

        /*
        |--------------------------------------------------------------------------
        | Auto generate table heading
        |--------------------------------------------------------------------------
        |
        | If set to true, the array indices (or model attribute names)
        | will automatically be used as first row (table heading)
        |
        */
        'generate_heading_by_indices' => true,

        /*
        |--------------------------------------------------------------------------
        | Auto set alignment on merged cells
        |--------------------------------------------------------------------------
        */
        'merged_cell_alignment'       => 'left',

        /*
        |--------------------------------------------------------------------------
        | Pre-calculate formulas during export
        |--------------------------------------------------------------------------
        */
        'calculate'                   => false,

        /*
        |--------------------------------------------------------------------------
        | Include Charts during export
        |--------------------------------------------------------------------------
        */
        'includeCharts'               => false,

        /*
        |--------------------------------------------------------------------------
        | Default sheet settings
        |--------------------------------------------------------------------------
        */
        'sheets'                      => [

            /*
            |--------------------------------------------------------------------------
            | Default page margin
            |--------------------------------------------------------------------------
            |
            | 1) When set to false, default margins will be used
            | 2) It's possible to enter a single margin which will
            |    be used for all margins.
            | 3) Alternatively you can pass an array with 4 margins
            |    Default order: array(top, right, bottom, left)
            |
            */
            'page_margin'          => false,

            /*
            |--------------------------------------------------------------------------
            | Value in source array that stands for blank cell
            |--------------------------------------------------------------------------
            */
            'nullValue'            => null,

            /*
            |--------------------------------------------------------------------------
            | Insert array starting from this cell address as the top left coordinate
            |--------------------------------------------------------------------------
            */
            'startCell'            => 'A1',

            /*
            |--------------------------------------------------------------------------
            | Apply strict comparison when testing for null values in the array
            |--------------------------------------------------------------------------
            */
            'strictNullComparison' => false
        ],
        
    ],

    'filters'    => [
        /*
        |--------------------------------------------------------------------------
        | Register read filters
        |--------------------------------------------------------------------------
        */

        'registered' => [
            'chunk' => 'Maatwebsite\Excel\Filters\ChunkReadFilter'
        ],

        /*
        |--------------------------------------------------------------------------
        | Enable certain filters for every file read
        |--------------------------------------------------------------------------
        */

        'enabled'    => []
    ],

    'views'      => [

        /*
        |--------------------------------------------------------------------------
        | Styles
        |--------------------------------------------------------------------------
        |
        | The default styles which will be used when parsing a view
        |
        */

        'styles' => [

            /*
            |--------------------------------------------------------------------------
            | Table headings
            |--------------------------------------------------------------------------
            */
            'th'     => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Strong tags
            |--------------------------------------------------------------------------
            */
            'strong' => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Bold tags
            |--------------------------------------------------------------------------
            */
            'b'      => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Italic tags
            |--------------------------------------------------------------------------
            */
            'i'      => [
                'font' => [
                    'italic' => true,
                    'size'   => 12,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Heading 1
            |--------------------------------------------------------------------------
            */
            'h1'     => [
                'font' => [
                    'bold' => true,
                    'size' => 24,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Heading 2
            |--------------------------------------------------------------------------
            */
            'h2'     => [
                'font' => [
                    'bold' => true,
                    'size' => 18,
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Heading 3
            |--------------------------------------------------------------------------
            */
            'h3'     => [
                'font' => [
                    'bold' => true,
                    'size' => 13.5,
                ]
            ],

            /*
             |--------------------------------------------------------------------------
             | Heading 4
             |--------------------------------------------------------------------------
             */
            'h4'     => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ]
            ],

            /*
             |--------------------------------------------------------------------------
             | Heading 5
             |--------------------------------------------------------------------------
             */
            'h5'     => [
                'font' => [
                    'bold' => true,
                    'size' => 10,
                ]
            ],

            /*
             |--------------------------------------------------------------------------
             | Heading 6
             |--------------------------------------------------------------------------
             */
            'h6'     => [
                'font' => [
                    'bold' => true,
                    'size' => 7.5,
                ]
            ],

            /*
             |--------------------------------------------------------------------------
             | Hyperlinks
             |--------------------------------------------------------------------------
             */
            'a'      => [
                'font' => [
                    'underline' => true,
                    'color'     => ['argb' => 'FF0000FF'],
                ]
            ],

            /*
             |--------------------------------------------------------------------------
             | Horizontal rules
             |--------------------------------------------------------------------------
             */
            'hr'     => [
                'borders' => [
                    'bottom' => [
                        'style' => 'thin',
                        'color' => ['FF000000']
                    ],
                ]
            ]
        ]

    ]

);
