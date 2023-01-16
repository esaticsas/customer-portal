<?php

namespace App\Console\Commands;

use Esatic\ActiveUser\Models\User;
use Illuminate\Console\Command;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esatic:users:reset {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for user';

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
     * @return int
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::query()->where('email', '=', $this->argument('email'))->firstOrFail();
        $password = $this->ask('New password.');
        $user->password = bcrypt($password);
        $user->save();
        $this->info('The user has been updated');
        return 0;
    }
}
