<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MhsMataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai = [
            [
                'mahasiswa_id' => '2041720070',
                'matakuliah_id' => '1',
                'nilai' => 'A+'
            ],
            [
                'mahasiswa_id' => '2041720071',
                'matakuliah_id' => '2',
                'nilai' => 'S'
            ],
            [
                'mahasiswa_id' => '2041720072',
                'matakuliah_id' => '3',
                'nilai' => 'SR'
            ],
            [
                'mahasiswa_id' => '2041720072',
                'matakuliah_id' => '4',
                'nilai' => 'S'
            ],
            [
                'mahasiswa_id' => '2041720073',
                'matakuliah_id' => '4',
                'nilai' => 'SSR'
            ]
        ];
        DB::table('mahasiswa_matakuliah')->insert($nilai);
    }
}
