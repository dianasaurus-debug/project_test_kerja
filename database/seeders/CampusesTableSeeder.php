<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CampusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campus::create([
            'nama_kampus' => 'Kampus A',
            'foto_kampus' => 'kampus_a.jpg',
            'peta_kampus' => 'peta_a',
            'alamat_kampus' => 'Jln Mayjend Sungkono',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Campus::create([
            'nama_kampus' => 'Kampus B',
            'peta_kampus' => 'peta_b',
            'foto_kampus' => 'kampus_b.jpg',
            'alamat_kampus' => 'Jln Mayjend Ali',
            'deskripsi' => 'Lorem Ipsum is simply jjjjjj text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'tanggal_dibangun' => Carbon::parse('2019-12-01')
        ]);
        Campus::create([
            'nama_kampus' => 'Kampus C',
            'peta_kampus' => 'peta_c',
            'alamat_kampus' => 'Jln Mayjend Dinar',
            'foto_kampus' => 'kampus_c.jpg',
            'deskripsi' => 'Lorem Ipsum is simply jjjjjj text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'tanggal_dibangun' => Carbon::parse('2019-12-01')
        ]);

    }
}
