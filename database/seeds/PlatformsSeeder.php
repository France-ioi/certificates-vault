<?php

use Illuminate\Database\Seeder;


class PlatformsSeeder extends Seeder
{

    public function run()
    {
        $platform = \App\Platform::create([
            'url' => 'http://test-ioi.test'
        ]);

        \App\PlatformString::create([
            'platform_id' => $platform->id,
            'name' => 'test platform name',
            'language_id' => \App\Language::first()->id
        ]);
    }
}