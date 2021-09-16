<?php

namespace App\Http\Resources;

use App\Models\Hall;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_gedung' => $this->nama_gedung,
            'kondisi_gedung' => $this->kondisi_gedung,
            'deskripsi' => $this->deskripsi,
            'kampus' => $this->campus->nama_kampus,
            'campus_id' => $this->campus_id,
            'tanggal_dibangun' => $this->tanggal_dibangun,
            'foto_gedung' => $this->foto_gedung,
            'rooms' => $this->rooms
        ];
    }
}
