<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['employee_code' => 'AT-00001',
            'name' => 'A Nguyen V.',
            'email' => 'a.nguyen@asiantech.vn',
            'team' => 'PHP',
            'role' => '0',
            ],
            ['employee_code' => 'AT-00002',
            'name' => 'B Le B.',
            'email' => 'b.le@asiantech.vn',
            'team' => 'IOS',
            'role' => '0',
            ],
            ['employee_code' => 'AT-00003',
            'name' => 'C Ho V.',
            'email' => 'c.ho@asiantech.vn',
            'team' => 'Android',
            'role' => '0',
            ],
            ['employee_code' => 'AT-00004',
            'name' => 'SA Tran',
            'email' => 'sa.tran@asiantech.vn',
            'team' => 'SA',
            'role' => '1',
            ],
            ['employee_code' => 'AT-00005',
            'name' => 'BO Le',
            'email' => 'bo.le@asiantech.vn',
            'team' => 'BO',
            'role' => '1',
            ],
            ['employee_code' => 'AT-00006',
            'name' => 'QC Dang',
            'email' => 'qc.dang@asiantech.vn',
            'team' => 'QC',
            'role' => '0',
            ]
        ]);
    }
}
