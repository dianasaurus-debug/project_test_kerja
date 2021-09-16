<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::create([
            'nama_ruang' => 'Ruang 1',
            'kondisi_ruang' => 'Baik',
            'foto_ruang' => 'ruang2.png',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'gedung_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Room::create([
            'nama_ruang' => 'Ruang 2',
            'kondisi_ruang' => 'Baik',
            'foto_ruang' => 'ruang2.png',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'gedung_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Room::create([
            'nama_ruang' => 'Pantry',
            'kondisi_ruang' => 'Perlu Direnovasi',
            'foto_ruang' => 'pantry.jpg',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'gedung_id' => 2,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);

        Room::create([
            'nama_ruang' => 'Ruang 1',
            'kondisi_ruang' => 'Baik',
            'foto_ruang' => 'ruang2.png',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'gedung_id' => 8,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
        Room::create([
            'nama_ruang' => 'Ruang 2',
            'kondisi_ruang' => 'Baik',
            'foto_ruang' => 'ruang2.png',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.',
            'gedung_id' => 8,
            'tanggal_dibangun' => Carbon::parse('2014-01-01')
        ]);
    }
}
