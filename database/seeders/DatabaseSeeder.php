<?php

namespace Database\Seeders;

use App\Models\{Unit, User};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $unit = Unit::factory()->create([
            'name'         => '8ª SR – São Luís/MA',
            'street'       => 'Avenida Senador Vitorino Freire',
            'number'       => 'nº 48',
            'complement'   => '',
            'neighborhood' => 'Areinha',
            'city'         => 'São Luís',
            'state'        => 'MA',
            'postal_code'  => '65030015',
            'phone'        => '9831981300',
            'email'        => 'gabinete.ma@codevasf.gov.br',
        ]);

        $admin = User::factory()->create([
            'name'    => 'Pedro Santiago',
            'email'   => 'joaopedrosantiago1103@gmail.com',
            'unit_id' => $unit->id,
        ]);

        $admin->assignRole('admin');

        $admin2 = User::factory()->create([
            'name'    => 'Carlos Victor',
            'email'   => 'carlos.anjos@codevasf.gov.br',
            'unit_id' => $unit->id,
        ]);

        $admin2->assignRole('admin');
    }
}
