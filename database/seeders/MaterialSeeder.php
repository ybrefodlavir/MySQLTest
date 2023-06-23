<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::insert([
            [
                'name' => 'Materi Insert',
                'description' => 'Materi Insert',
                'order' => 1,
                'color' => 'merah',
                'is_exam' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Materi Update',
                'description' => 'Materi Update',
                'order' => 2,
                'color' => 'biru',
                'is_exam' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Materi Delete',
                'description' => 'Materi Delete',
                'order' => 3,
                'color' => 'kuning',
                'is_exam' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Exam',
                'description' => 'Exam',
                'order' => 4,
                'color' => 'hijau',
                'is_exam' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
