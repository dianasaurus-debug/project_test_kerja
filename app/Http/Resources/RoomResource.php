<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'nama_ruang' => $this->nama_ruang,
            'kondisi_ruang' => $this->kondisi_ruang,
            'deskripsi' =>$this->deskripsi,
            'gedung' => $this->hall->nama_gedung,
            'gedung_id' => $this->gedung_id,
            'tanggal_dibangun' => $this->tanggal_dibangun,
            'foto_ruang' => $this->foto_ruang,

        ];
    }
}
