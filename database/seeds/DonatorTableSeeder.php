<?php

use Illuminate\Database\Seeder;
use App\Model\Donator;

class DonatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donator')->insert([
            ['user_id' => null,
            'employee_code' => 'AT-00011',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => '1',
            'employee_code' => 'AT-00001',
            'email' => 'a.nguyen@asiantech.vn',
            ],
            ['user_id' => '2',
            'employee_code' => 'AT-00002',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => '3',
            'employee_code' => 'AT-00013',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
            'employee_code' => 'AT-00015',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
            'employee_code' => 'AT-00008',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
            'employee_code' => 'AT-00007',
            'email' => 'abc.nguyen@asiantech.vn',
            ],
        ]);
    }
}
