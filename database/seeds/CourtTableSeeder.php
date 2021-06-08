<?php

use Illuminate\Database\Seeder;

class CourtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable();
        $courts = [
            ['name' => 'محكمة العدل العليا'],
            ['name' => 'محكمة النقض'],
            ['name' => 'المحكمة الادارية'],
            ['name' => 'محكمة الاستئناف'],
            ['name' => 'محكمة بداية غزة'],
            ['name' => 'محكمة بداية خانيونس'],
            ['name' => 'محكمة بداية دير البلح'],
            ['name' => 'محكمة صلح غزة'],
            ['name' => 'محكمة صلح الشمال'],
            ['name' => 'محكمة صلح دير البلح'],
            ['name' => 'محكمة صلح خانيونس'],
            ['name' => 'محكمة صلح رفح'],

        ];
        \DB::table('courts')->insert($courts);
    }

    public function truncateTable()
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\Court::truncate();
        Schema::enableForeignKeyConstraints();
    }


}
