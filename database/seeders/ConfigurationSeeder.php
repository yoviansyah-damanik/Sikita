<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                'attribute' => 'app_name',
                'value' => config('app.name'),
                'type' => 'string',
                'description' => 'Nama aplikasi'
            ],
            [
                'attribute' => 'app_fullname',
                'value' => config('app.fullname'),
                'type' => 'string',
                'description' => 'Nama panjang aplikasi'
            ],
            [
                'attribute' => 'even_semester',
                'value' => '01-08',
                'type' => 'string',
                'description' => 'Semester Ganjil'
            ],
            [
                'attribute' => 'odd_semester',
                'value' => '01-02',
                'type' => 'string',
                'description' => 'Semester Genap'
            ],
        ];

        $configs = collect($configs)
            ->map(fn ($config) => [...$config, ...['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]])
            ->toArray();

        Configuration::insert($configs);
    }
}
