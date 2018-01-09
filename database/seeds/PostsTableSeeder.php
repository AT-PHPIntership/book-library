<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 1,
             'postable_type' => 'books',
             'type' => 'review',
             'user_id' => 1,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => null,
             'postable_type' => null,
             'type' => 'status',
             'user_id' => 2,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 2,
             'postable_type' => 'posts',
             'type' => 'commnet',
             'user_id' => 4,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 1,
             'postable_type' => 'post',
             'type' => 'comment',
             'user_id' => 1,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => null,
             'postable_type' => null,
             'type' => 'find',
             'user_id' => 5,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 2,
             'postable_type' => 'post',
             'type' => 'comment',
             'user_id' => 4,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 10,
             'postable_type' => 'books',
             'type' => 'review',
             'user_id' => 6,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 4,
             'postable_type' => 'books',
             'type' => 'review',
             'user_id' => 2,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 4,
             'postable_type' => 'posts',
             'type' => 'comment',
             'user_id' => 1,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 1,
             'postable_type' => 'books',
             'type' => 'review',
             'user_id' => 1,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 1,
             'postable_type' => 'books',
             'type' => 'review',
             'user_id' => 1,
            ],
            ['content' => 'My whole world changed from the moment I met you 
             And it would never be the same 
             Felt like I knew that I’d always love you 
             From the moment I heard your name ',
             'postable_id' => 2,
             'postable_type' => 'post',
             'type' => 'comment',
             'user_id' => 5,
            ],
        ]);
    }
}
