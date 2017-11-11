<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class PurgeUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purgeusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy accounts that have not been verified in over 2 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usersToPurge = User::where('verified', 0)->where('created_at', '<=', now()->subDays(2)->toDateTimeString())->where('created_at', '>=', now()->subDays(3)->toDateTimeString())->get();

        if (sizeof($usersToPurge) === 0)
        {
            echo 'There are no users to be deleted.';
            return;
        }

        echo "Deleting " . sizeof($usersToPurge) . " users.";

        foreach ($usersToPurge as $user) {
            $user->delete();
        }
        echo "\nFinished deleting " . sizeof($usersToPurge) . ' non verified users!';
    }
}
