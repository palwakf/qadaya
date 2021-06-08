<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable();
        $data = [
            [
                'username' => 'admin',
                'name' => 'admin',
                'email' => 'admin@palwakf.net',
                'password' =>  bcrypt(123456),
                'status' => 1,
            ],
            [
                'username' => 'law',
                'name' => 'محامي',
                'email' => 'law@palwakf.net',
                'password' =>  bcrypt(123456),
                'status' => 1,
            ]
        ];
        \App\Models\User::insert($data);
    }

    public function truncateTable()
    {
        Schema::disableForeignKeyConstraints();
         \App\Models\User::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
