<?php

namespace Database\Seeders;

use App\Models\GuidanceGroup;
use Illuminate\Database\Seeder;

class GuidanceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Seminar Proposal',
                'description' => 'Bimbingan Seminar Proposal',
                'groups' => [
                    [
                        'name' => 'BAB 1 Pendahuluan',
                        'description' => 'Penjelasan tentang latar belakang, rumusan masalah, tujuan penelitian, manfaat penelitian, dan sistematika penelitian.'
                    ],
                    [
                        'name' => 'BAB 2 Tinjauan Pustaka',
                        'description' => 'Penjelasan tentang landasan teori dan penelitian terdahulu.'
                    ],
                    [
                        'name' => 'BAB 3 Metodologi Penelitian',
                        'description' => 'Penjelasan tentang alat dan kebutuhan yang digunakan dalam penelitian.'
                    ]
                ],
            ],
            [
                'name' =>  'Seminar Hasil',
                'description' => 'Bimbingan Seminar Hasil',
                'groups' => [
                    [
                        'name' => 'BAB 1 Pendahuluan',
                        'description' => 'Penjelasan tentang latar belakang, rumusan masalah, tujuan penelitian, manfaat penelitian, dan sistematika penelitian.'
                    ],
                    [
                        'name' => 'BAB 2 Tinjauan Pustaka',
                        'description' => 'Penjelasan tentang landasan teori dan penelitian terdahulu.'
                    ],
                    [
                        'name' => 'BAB 3 Metodologi Penelitian',
                        'description' => 'Penjelasan tentang alat dan kebutuhan yang digunakan dalam penelitian.'
                    ],
                    [
                        'name' => 'BAB 4 Hasil dan Pembahasan',
                        'description' => 'Penjelasan tentang hasil dan pembahasan penelitian.'
                    ],
                    [
                        'name' => 'BAB 5 Penutup',
                        'description' => 'Penjelasan tentang kesimpulan dan saran.'
                    ],
                    [
                        'name' => 'Lain-lain',
                        'description' => 'Penjelasan tentang hal-hal lain yang berkaitan dengan penelitian. Contoh: Aplikasi, Prototype Penelitian, dsb.'
                    ],
                ]
            ],
            [
                'name' =>  'Sidang',
                'description' => 'Bimbingan Sidang',
                'groups' => [
                    [
                        'name' => 'BAB 1 Pendahuluan',
                        'description' => 'Penjelasan tentang latar belakang, rumusan masalah, tujuan penelitian, manfaat penelitian, dan sistematika penelitian.'
                    ],
                    [
                        'name' => 'BAB 2 Tinjauan Pustaka',
                        'description' => 'Penjelasan tentang landasan teori dan penelitian terdahulu.'
                    ],
                    [
                        'name' => 'BAB 3 Metodologi Penelitian',
                        'description' => 'Penjelasan tentang alat dan kebutuhan yang digunakan dalam penelitian.'
                    ],
                    [
                        'name' => 'BAB 4 Hasil dan Pembahasan',
                        'description' => 'Penjelasan tentang hasil dan pembahasan penelitian.'
                    ],
                    [
                        'name' => 'BAB 5 Penutup',
                        'description' => 'Penjelasan tentang kesimpulan dan saran.'
                    ],
                    [
                        'name' => 'Lain-lain',
                        'description' => 'Penjelasan tentang hal-hal lain yang berkaitan dengan penelitian. Contoh: Aplikasi, Prototype Penelitian, dsb.'
                    ],
                ]
            ]
        ];

        foreach ($groups as $group) {
            GuidanceGroup::create([
                'name' => $group['name'],
                'description' => $group['description']
            ])->types()->createMany(
                $group['groups']
            );
        }
    }
}
