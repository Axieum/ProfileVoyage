<?php

use Illuminate\Database\Seeder;

class SocialPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add a platform here ('name' => 'display_name')
        $platforms = array(
            'twitter' => 'Twitter'
        );

        foreach ($platforms as $name => $displayName) {
            if (!DB::table('social_platforms')->where('name', $name)->exists())
            {
                DB::table('social_platforms')->insert([
                    'name' => $name,
                    'display_name' => $displayName
                ]);
            }
        }
    }
}
