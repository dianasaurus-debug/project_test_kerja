<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HallResource;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $halls = Hall::all();
        return HallResource::collection($halls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_gedung' => 'required|max:255',
            'deskripsi' => 'required|string',
            'kondisi_gedung' => 'required|string',
            'campus_id' => 'required|numeric',
            'tanggal_dibangun' => 'required|date',
            'foto_gedung' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->foto_gedung->getClientOriginalExtension();
        $request->foto_gedung->move(public_path('images/gedung'), $imageName);

        $gedung = Hall::create([
            'nama_gedung' => $request->nama_gedung,
            'deskripsi' => $request->deskripsi,
            'kondisi_gedung' => $request->kondisi_gedung,
            'campus_id' => $request->campus_id,
            'tanggal_dibangun' => $request->tanggal_dibangun,
            'foto_gedung' => $imageName
        ]);
        return response()->json('Data Gedung ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gedung = Hall::findOrFail($id);
        HallResource::withoutWrapping();

        return new HallResource($gedung);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gedung = Hall::findOrFail($id);
        if($request->hasFile('foto_gedung')){
            $this->validate($request, [
                'nama_gedung' => 'required|max:255',
                'deskripsi' => 'required|string',
                'kondisi_gedung' => 'required|string',
                'campus_id' => 'required|numeric',
                'tanggal_dibangun' => 'required|date',
                'foto_gedung' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $path = public_path().'/images/gedung/';

            //code for remove old file
            if($gedung->foto_gedung != ''  && $gedung->foto_gedung != null){
                $file_old = $path.$gedung->foto_gedung;
                unlink($file_old);
            }
            //upload new file
            $file = $request->foto_gedung;
            $filename = time().'.'.$file->getClientOriginalName();
            $file->move($path, $filename);
            $gedung->update(['foto_gedung' => $filename]);
            $gedung->update(['nama_gedung' => $request->nama_gedung]);
            $gedung->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $gedung->update(['deskripsi' => $request->deskripsi]);
            $gedung->update(['campus_id' => $request->campus_id]);
            $gedung->update(['kondisi_gedung' => $request->kondisi_gedung]);
            return response()->json('Data Gedung sukses diupdate', 200);
        } else {
            $this->validate($request, [
                'nama_gedung' => 'required|max:255',
                'deskripsi' => 'required|string',
                'kondisi_gedung' => 'required|string',
                'campus_id' => 'required|numeric',
                'tanggal_dibangun' => 'required|date',
            ]);
            $gedung->update(['nama_gedung' => $request->nama_gedung]);
            $gedung->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $gedung->update(['deskripsi' => $request->deskripsi]);
            $gedung->update(['campus_id' => $request->campus_id]);
            $gedung->update(['kondisi_gedung' => $request->kondisi_gedung]);
            return response()->json('Data Gedung sukses diupdate', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gedung = Hall::findOrFail($id);
        $image_path = public_path("images/gedung/".$gedung->foto_gedung);

        if(file_exists($image_path)){
            //File::delete($image_path);
            File::delete( $image_path);
        }
        $gedung->delete();
        return response()->json('Data Gedung dihapus', 200);
    }
}
