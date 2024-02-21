<?php

namespace Database\Seeders;

use App\Models\FilamentPage;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'filament_page_id' => 9,
                'title' => 'Employees',
                'data' => '{"template":"App\\\Filament\\\Custom\\\Templates\\\WYSIWYG","templateName":null,"content":{"sliders":{"9aab89b6-6e2f-4a54-83e6-dc58f84f9bdb":{"sliderTitle":null,"sliderContent":null,"sliderButton":null,"sliderButtonLink":null,"sliderImage":[]}},"editors":[{"text":null}],"paragraphTitle":null,"paragraphText":null,"paragraphImage":[],"attachments":[],"services":[],"Example template":null,"paragraphButton":null,"paragraphButtonLink":null,"images":{"0ded26de-0cfe-4cf6-acf4-b390fbd7c09a":{"paragraphImage":[],"imageDescription":null}}}}',
                'created_at' => now(),
                'updated_at' => now(),
                'order' => 1,
                'fixed_section' => 1,
            ],
            [
                'filament_page_id' => 1,
                'title' => 'Services',
                'data' => '{"template":"App\\\Filament\\\Custom\\\Templates\\\Gallery","templateName":null,"content":{"sliders":{"c5559a4c-57bc-451c-a852-152af1fb4fc0":{"sliderTitle":null,"sliderContent":null,"sliderButton":null,"sliderButtonLink":null,"sliderImage":[]}},"editors":{"074587fb-5e86-4e1f-b9ca-97127bca6791":{"text":null}},"paragraphTitle":null,"paragraphText":null,"paragraphImage":[],"attachments":[],"services":[],"Example template":null,"paragraphButton":null,"paragraphButtonLink":null,"images":[{"imageDescription":null}]}}',
                'created_at' => now(),
                'updated_at' => now(),
                'order' => 2,
                'fixed_section' => 1,
            ],
            [
                'filament_page_id' => 8,
                'title' => 'Articles',
                'data' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'order' => 3,
                'fixed_section' => 1,
            ],
            [
                'filament_page_id' => 7,
                'title' => 'ContactForm',
                'data' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'order' => 4,
                'fixed_section' => 1,
            ],
            [
                'filament_page_id' => 2,
                'title' => 'SearchBar',
                'data' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'order' => 2,
                'fixed_section' => 1,
            ],
        ];

        Section::insert($data);
    }
}
