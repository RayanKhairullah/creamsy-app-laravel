<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MakeCashierCommand extends Command
{
    protected $signature = 'make:cashier {name} {email} {password}';
    protected $description = 'Create a new cashier user';

    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
        ]);
        $user->assignRole('Cashier');
        $this->info('Cashier created: ' . $user->email);
    }
}
