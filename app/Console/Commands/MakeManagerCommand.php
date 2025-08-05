<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MakeManagerCommand extends Command
{
    protected $signature = 'make:manager {name} {email} {password}';
    protected $description = 'Create a new manager user';

    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
        ]);
        $user->assignRole('Manager');
        $this->info('Manager created: ' . $user->email);
    }
}
