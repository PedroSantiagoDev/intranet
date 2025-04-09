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
            'number'                => 'nº 48',
            'complement'            => '',
            'neighborhood'          => 'Areinha',
            'city'                  => 'São Luís',
            'state'                 => 'MA',
            'postal_code'           => '65030-015',
            'phone'                 => '(98)3198-1300',
            'email'                 => 'gabinete.ma@codevasf.gov.br',
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
