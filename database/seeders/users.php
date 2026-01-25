<?php

use App\Models\User;
use Support\Vault\Database\Seeder;

return new class extends Seeder {

    public static function run(): void
    {   
        User::create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'alice@example.com',
            'password' => password_hash('AliceSmith', PASSWORD_DEFAULT),
            'activated' => 1,
        ]);

        User::create([
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'password' => password_hash('BobJohnson', PASSWORD_DEFAULT),
            'activated' => 1,
        ]);
    }
};