<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'title'     => 'Site Oficial Laravel',
                'url'       => 'https://laravel.com',
                'is_active' => true,
            ],
            [
                'title'     => 'Filament PHP',
                'url'       => 'https://filamentphp.com',
                'is_active' => true,
            ],
            [
                'title'     => 'Laracasts',
                'url'       => 'https://laracasts.com',
                'is_active' => true,
            ],
            [
                'title'     => 'Laravel News',
                'url'       => 'https://laravel-news.com',
                'is_active' => true,
            ],
            [
                'title'     => 'GitHub',
                'url'       => 'https://github.com',
                'is_active' => true,
            ],
            [
                'title'     => 'Stack Overflow',
                'url'       => 'https://stackoverflow.com',
                'is_active' => false,
            ],
            [
                'title'     => 'Digital Ocean',
                'url'       => 'https://digitalocean.com',
                'is_active' => true,
            ],
            [
                'title'     => 'Tailwind CSS',
                'url'       => 'https://tailwindcss.com',
                'is_active' => true,
            ],
            [
                'title'     => 'PHP.net',
                'url'       => 'https://php.net',
                'is_active' => false,
            ],
        ];

        foreach ($links as $link) {
            Link::create($link);
        }
    }
}
