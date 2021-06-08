<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable();
        $types = [
            ['name' => 'اثبات صحة عقد ونفاذ'],
            ['name' => 'ايداع'],
            ['name' => 'استئناف'],
            ['name' => 'ابراء ذمة'],
            ['name' => 'مأجور'],
            ['name' => 'اخلاء مأجور'],
            ['name' => 'اخلاء مأجور بسبب التمنع عن دفع الأجرة'],
            ['name' => 'اخلاء مأجور بسبب مخالفة شروط العقد'],
            ['name' => 'اخلاء مأجور بسبب الوفاة'],
            ['name' => 'اخلاء للهدم والبناء'],
            ['name' => 'تقسيم أموال'],
            ['name' => 'تقسيم أموال مشتركة'],
            ['name' => 'فك الحجز'],
            ['name' => 'فسخ اتفاق'],

        ];
        \DB::table('types')->insert($types);
    }
    public function truncateTable()
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\Type::truncate();
        Schema::enableForeignKeyConstraints();
    }

}
