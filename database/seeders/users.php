<?php

use App\Models\User;
use Support\Vault\Database\Seeder;

return new class extends Seeder {

    public static function run(): void
    {   
        User::create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT),
        ]);

        User::create([
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT),
        ]);
    }
};