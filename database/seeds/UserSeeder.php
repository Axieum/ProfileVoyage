<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->profile()->save(factory(App\Profile::class)->make());

            // Email Verification
            $key = config('app.key');

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            DB::table('email_verifications')->insert([
                'user_id' => $user->id,
                'token' => hash_hmac('sha256', Str::random(40), $key),
                'created_at' => now()
            ]);
        });
    }
}
