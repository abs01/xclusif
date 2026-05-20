<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tier;
use App\Models\Role;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'      => 'admin',
            'lastname'  => 'admin',
            'dni'       => '00000000A',
            'email'     => 'admin@xclusif.com',
            'email_verified_at' => now(),
            'phone'     => '971123456',
            'password'  => Hash::make('12345678'),
            'role_id'   => Role::where('name', 'admin')->value('id'),
            'tier_id'   => Tier::where('name', 'diamond')->value('id'),

        ]);

        $jsonData = file_get_contents("database\jsons\users.json");
        $usuaris = json_decode($jsonData, true);

        $gestorRole = Role::where('name', 'moderador')->value('id');
        $tierRole = Tier::where('name', 'diamond')->value('id');

        foreach ($usuaris['usuaris']['usuari'] as $usuari) {
            User::create([
                'name'      => $usuari['name'],
                'lastname'  => $usuari['lastname'],
                'dni'       => $usuari['dni'],
                'email'     => $usuari['email'],
                'email_verified_at' => now(),
                'phone'     => $usuari['phone'],
                'password'  => Hash::make($usuari['password']),
                'role_id'   => $gestorRole,
                'tier_id'   => $tierRole,
            ]);
        }    }
}
