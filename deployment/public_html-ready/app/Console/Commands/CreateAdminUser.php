<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::where('email', 'admin@psa.com')->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@psa.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
            $this->info('Admin user created');
        } else {
            $this->info('Admin user already exists');
        }
        $this->info('Email: admin@psa.com');
        $this->info('Password: password');
    }
}
