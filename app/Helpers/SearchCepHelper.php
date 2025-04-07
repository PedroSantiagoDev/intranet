<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SearchCepHelper
{
    /**
     * @return array<string, string>
     */
    public static function search(?string $cep = null): null|array
    {
        if (empty($cep)) {
            return null;
        }

        $cep = preg_replace('/[^0-9]/', '', $cep);

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->ok() && !$response->json('erro')) {
            return $response->json();
        }

        return null;
    }
}
