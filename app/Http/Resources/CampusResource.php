<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampusResource extends JsonResource
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
            'nama_kampus' => $this->nama_kampus,
            'deskripsi' => $this->deskripsi,
            'alamat_kampus' => $this->alamat_kampus,
            'peta_kampus' => $this->peta_kampus,
            'foto_kampus' => $this->foto_kampus,
            'tanggal_dibangun' => $this->tanggal_dibangun,
            'halls' => $this->halls,
        ];
    }
}
