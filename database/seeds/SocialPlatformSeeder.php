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
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
            'battlenet' => 'Battle.net',
            'vimeo' => 'Vimeo',
            'discord' => 'Discord',
            'reddit' => 'Reddit',
            'google' => 'Google+',
            'instagram' => 'Instagram',
            'imgur' => 'Imgur',
            'linkedin' => 'LinkedIn',
            'live' => 'Microsoft Live',
            'steam' => 'Steam',
            'twitch' => 'Twitch',
            'dribbble' => 'Dribbble',
            'deviantart' => 'DeviantArt',
            'tumblr' => 'Tumblr',
            'flickr' => 'Flickr',
            'medium' => 'Medium',
            'mixer' => 'Mixer',
            'unsplash' => 'Unsplash',
            'etsy' => 'Etsy',
            'dailymotion' => 'Dailymotion',
            'patreon' => 'Patreon',
            // 'soundcloud' => 'SoundCloud',
            'spotify' => 'Spotify',
            'stackexchange' => 'Stack Overflow',
            '500px' => '500px'
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
