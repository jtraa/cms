<?php

namespace Database\Seeders;

use App\Models\FilamentPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                [
                    'slug' => 'diensten',
                    'title' => 'Diensten',
                    'data' => '',
                    'id' => 1,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 3,
                    'in_menu' => 1,
                    'fixed_page' => 1,
                ],
                [
                    'slug' => 'home',
                    'title' => 'Home',
                    'data' => '',
                    'id' => 2,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 1,
                    'in_menu' => 1,
                    'fixed_page' => 1,
                ],
                [
                    'slug' => 'opleidingen',
                    'title' => 'Opleidingen',
                    'data' => '',
                    'id' => 3,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 2,
                    'in_menu' => 1,
                    'fixed_page' => 0,
                ],
                [
                    'slug' => 'contact',
                    'title' => 'Contact',
                    'data' => '',
                    'id' => 7,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 7,
                    'in_menu' => 1,
                    'fixed_page' => 1,
                ],
                [
                    'slug' => 'nieuws',
                    'title' => 'Nieuws',
                    'data' => '',
                    'id' => 8,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 6,
                    'in_menu' => 1,
                    'fixed_page' => 1,
                ],
                [
                    'slug' => 'team',
                    'title' => 'Team',
                    'data' => '',
                    'id' => 9,
                    'published_at' => '2023-01-01 00:00:00',
                    'published_until' => '2099-12-31 23:59:59',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'order' => 4,
                    'in_menu' => 1,
                    'fixed_page' => 1,
                ]
        ];

        FilamentPage::insert($data);
    }
}
