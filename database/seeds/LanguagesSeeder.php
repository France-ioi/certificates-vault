<?php

use Illuminate\Database\Seeder;


class LanguagesSeeder extends Seeder
{

    public function run()
    {
        \App\Language::create([
            'code' => 'en',
            'name' => 'English'
        ]);
    }
}