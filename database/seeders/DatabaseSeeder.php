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
        Unit::factory()->create([
            'name'                  => '8ª SR – São Luís/MA',
            'sender_name'           => 'CODEVASF MA',
            'street'                => 'Avenida Senador Vitorino Freire',
            'number'                => '48',
            'neighborhood'          => 'Areinha',
            'city'                  => 'Maranhão',
            'state'                 => 'MA',
            'postal_code'           => '70000000',
            'matrix_code'           => 'MMDF2024',
            'contract_number'       => 'CT2024DF',
            'postage_card'          => 'PC1234DF',
            'administrative_number' => 'ADM2024',
            'posting_unit'          => 'UNIDF01',
        ]);

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
