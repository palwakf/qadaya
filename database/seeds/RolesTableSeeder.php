<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();
        $data = [
            [
                'id' => 1,
                'name' => 'Admin',
                'guard_name' => 'admin',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'Employee',
                'guard_name' => 'admin',
                'status' => 1
            ]
        ];
        \DB::table('roles')->insert($data);
    }

}
