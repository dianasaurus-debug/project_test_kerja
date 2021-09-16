<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class hallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hall::create([
            'nama_gedung' => 'Gedung 1',
            'foto_gedung' => 'gedung1_kampus_a.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 1,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Gedung 2',
            'foto_gedung' => 'gedung_2.jpg',
            'kondisi_gedung' => 'Perlu Direnovasi',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 1,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Masjid',
            'foto_gedung' => 'masjid.jpeg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 1,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Kantin',
            'foto_gedung' => 'kantin.jpg',
            'kondisi_gedung' => 'Sedang Direnovasi',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Gedung 1',
            'foto_gedung' => 'gedung1_kampus_a.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Parkir',
            'foto_gedung' => 'parkir.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Silo',
            'foto_gedung' => 'silo.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Gedung 1',
            'foto_gedung' => 'gedung1_kampus_a.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 3,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Hall::create([
            'nama_gedung' => 'Green house',
            'foto_gedung' => 'green_house.jpg',
            'kondisi_gedung' => 'Baik',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'campus_id' => 3,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
    }
}
