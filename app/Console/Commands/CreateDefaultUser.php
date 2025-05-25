<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUser extends Command
{ protected $signature = 'passwords:hash-admin';
    protected $description = 'Hacher les mots de passe des administrateurs existants';

    public function handle()
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            if (!Hash::needsRehash($admin->password)) {
                continue; // Skip if the password is already hashed
            }

            $admin->password = Hash::make($admin->password);
            $admin->save();
        }

        $this->info('Mots de passe des administrateurs hachés avec succès.');
    }
}