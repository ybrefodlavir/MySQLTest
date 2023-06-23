<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::insert([
            [
                'question' => "1. Terdapat sebuah tabel yang bernama students.Masukkan data berikut kedalam tabel students : [id : 4 ,name : daffa,nim : 19457894]",
                'type' => Question::$InsertSingle,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,nim,name", "whereRaw": "id=4"}',
                'validation_value' => '{"id":4,"name": "daffa","nim": "19457894"}',
                'difficulty' => Question::$Easy,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "2. Masukkan data berikut kedalam tabel students : [id : 5, name : widiareta,nim : 194173475],[id : 6, name : ariono, nim : 194394613]",
                'type' => Question::$InsertMultiple,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim", "whereRaw": "id IN (5,6)"}',
                'validation_value' => '[{"id":5,"name": "widiareta", "nim":"194173475"},{"id":6,"name": "ariono", "nim":"194394613"}]',
                'difficulty' => Question::$Medium,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "3.Masukkan data berikut tetapi hanya column id dan nim saja : [id : 7, nim : 194629423]",
                'type' => Question::$InsertSingleSpecific,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim", "whereRaw": "id=7", "nullKey": "name"}',
                'validation_value' => '{"id":7,"nim":"194629423"}',
                'difficulty' => Question::$Hard,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "4.Dalam tabel students terdapat column nim.Ubahlah value nim yang ada di tabel students menjadi seperti ini. nim : 1836758303",
                'type' => Question::$UpdateAll,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim"}',
                'validation_value' => '[{"id":1,"name": "rivaldo", "nim":"1836758303"},{"id":2,"name": "omar", "nim":"1836758303"},{"id":3, "name" : "baggio", "nim" : "1836758303"}]',
                'difficulty' => Question::$Easy,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "5.Ubahlah data di tabel students yang memiliki id kurang dari 3 menjadi name=ferby,nim=12345",
                'type' => Question::$UpdateSpecific,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim", "whereRaw": "id<3"}',
                'validation_value' => '[{"id":1,"name": "ferby", "nim":"12345"},{"id":2,"name": "ferby", "nim":"12345"}]',
                'difficulty' => Question::$Medium,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "6.update column name=aquarel di table students yang memiliki id=1",
                'type' => Question::$UpdateSpecific,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim", "whereRaw": "id=1"}',
                'validation_value' => '[{"id":1,"name": "aquarel", "nim":"194172"}]',
                'difficulty' => Question::$Medium,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "7.Hapus data dimana data dalam tabel memiliki nim=null",
                'type' => Question::$DeleteSpecific,
                'validation_statement' => '{"tableName":"students", "selectRaw":"id,name,nim", "whereRaw": "nim=null"}',
                'validation_value' => null,
                'difficulty' => Question::$Medium,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'question' => "8.Hapus semua data di dalam tabel students",
                'type' => Question::$DeleteAll,
                'validation_statement' => '{"tableName":"students"}',
                'validation_value' => null,
                'difficulty' => Question::$Medium,

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
