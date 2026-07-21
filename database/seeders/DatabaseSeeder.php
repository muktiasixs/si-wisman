<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Sumber Data
        DB::table('sumber_data')->insert([
            ['id_sumber' => 1, 'nama_sumber' => 'BPS'],
            ['id_sumber' => 2, 'nama_sumber' => 'UN WTO'],
        ]);

        // 2. Insert Negara (Tanpa kode_negara)
        DB::table('negara')->insert([
            ['id_negara' => 1, 'nama_negara' => 'BRUNEI D', 'id_sumber' => 1],
            ['id_negara' => 2, 'nama_negara' => 'MALAYSIA', 'id_sumber' => 1],
            ['id_negara' => 3, 'nama_negara' => 'PHILIPPINES', 'id_sumber' => 1],
            ['id_negara' => 4, 'nama_negara' => 'SINGAPORE', 'id_sumber' => 1],
            ['id_negara' => 5, 'nama_negara' => 'THAILAND', 'id_sumber' => 2],
            ['id_negara' => 6, 'nama_negara' => 'VIETNAM', 'id_sumber' => 2],
            ['id_negara' => 7, 'nama_negara' => 'LAOS', 'id_sumber' => 2],
            ['id_negara' => 8, 'nama_negara' => 'INDONESIA', 'id_sumber' => null],
        ]);

        // 3. Insert Kunjungan
        $kunjunganAsli = [
            // Brunei (1) -> Indonesia (8)
            [1, 1, 8, 'Jan', 747], [2, 1, 8, 'Feb', 1251], [3, 1, 8, 'Mar', 999], [4, 1, 8, 'Apr', 857], [5, 1, 8, 'Mei', 1359],
            // Malaysia (2) -> Indonesia (8)
            [6, 2, 8, 'Jan', 155213], [7, 2, 8, 'Feb', 218057], [8, 2, 8, 'Mar', 160269], [9, 2, 8, 'Apr', 170644], [10, 2, 8, 'Mei', 200070],
            // Philippines (3) -> Indonesia (8)
            [11, 3, 8, 'Jan', 16937], [12, 3, 8, 'Feb', 18367], [13, 3, 8, 'Mar', 20469], [14, 3, 8, 'Apr', 17726], [15, 3, 8, 'Mei', 19462],
            // Singapore (4) -> Indonesia (8)
            [16, 4, 8, 'Jan', 85118], [17, 4, 8, 'Feb', 114301], [18, 4, 8, 'Mar', 120040], [19, 4, 8, 'Apr', 81225], [20, 4, 8, 'Mei', 111021],
            // Thailand (5) -> Indonesia (8)
            [21, 5, 8, 'Jan', 7349], [22, 5, 8, 'Feb', 8777], [23, 5, 8, 'Mar', 8691], [24, 5, 8, 'Apr', 9791], [25, 5, 8, 'Mei', 10081],
            // Vietnam (6) -> Indonesia (8)
            [26, 6, 8, 'Jan', 6102], [27, 6, 8, 'Feb', 9566], [28, 6, 8, 'Mar', 9253], [29, 6, 8, 'Apr', 9590], [30, 6, 8, 'Mei', 10191],
            // Laos (7) -> Indonesia (8)
            [31, 7, 8, 'Jan', 139], [32, 7, 8, 'Feb', 211], [33, 7, 8, 'Mar', 198], [34, 7, 8, 'Apr', 261], [35, 7, 8, 'Mei', 255],
        ];

        foreach ($kunjunganAsli as $k) {
            DB::table('kunjungan')->insert([
                'id_kunjungan' => $k[0],
                'id_negara_asal' => $k[1],
                'id_negara_tujuan' => $k[2],
                'bulan' => $k[3],
                'jumlah' => $k[4],
            ]);
        }
    }
}
