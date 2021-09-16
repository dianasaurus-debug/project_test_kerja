<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Hall;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return RoomResource::collection($rooms);
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
            'nama_ruang' => 'required|max:255',
            'deskripsi' => 'required|string',
            'kondisi_ruang' => 'required|string',
            'gedung_id' => 'required|numeric',
            'tanggal_dibangun' => 'required|date',
            'foto_ruang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->foto_ruang->getClientOriginalExtension();
        $request->foto_ruang->move(public_path('images/ruang'), $imageName);

        $ruang = Room::create([
            'nama_ruang' => $request->nama_ruang,
            'deskripsi' => $request->deskripsi,
            'kondisi_ruang' => $request->kondisi_ruang,
            'gedung_id' => $request->ruang_id,
            'tanggal_dibangun' => $request->tanggal_dibangun,
            'foto_ruang' => $imageName
        ]);
        return response()->json([
            'message' => 'Sukses add data',
            'data' => $ruang
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruang = Room::findOrFail($id);
        RoomResource::withoutWrapping();

        return new RoomResource($ruang);
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
        $ruang = Room::findOrFail($id);
        if($request->hasFile('foto_ruang')){
            $this->validate($request, [
                'nama_ruang' => 'required|max:255',
                'deskripsi' => 'required|string',
                'kondisi_ruang' => 'required|string',
                'gedung_id' => 'required|numeric',
                'tanggal_dibangun' => 'required|date',
                'foto_ruang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $path = public_path().'/images/ruang/';

            //code for remove old file
            if($ruang->foto_ruang != ''  && $ruang->foto_ruang != null){
                $file_old = $path.$ruang->foto_ruang;
                unlink($file_old);
            }
            //upload new file
            $file = $request->foto_ruang;
            $filename = time().'.'.$file->getClientOriginalName();
            $file->move($path, $filename);
            $ruang->update(['foto_ruang' => $filename]);
            $ruang->update(['nama_ruang' => $request->nama_ruang]);
            $ruang->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $ruang->update(['deskripsi' => $request->deskripsi]);
            $ruang->update(['gedung_id' => $request->gedung_id]);
            $ruang->update(['kondisi_ruang' => $request->kondisi_ruang]);
            return response()->json('Data Ruang sukses diupdate', 200);
        } else {
            $this->validate($request, [
                'nama_ruang' => 'required|max:255',
                'deskripsi' => 'required|string',
                'kondisi_ruang' => 'required|string',
                'gedung_id' => 'required|numeric',
                'tanggal_dibangun' => 'required|date',
            ]);
            $ruang->update(['nama_ruang' => $request->nama_ruang]);
            $ruang->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $ruang->update(['deskripsi' => $request->deskripsi]);
            $ruang->update(['gedung_id' => $request->gedung_id]);
            $ruang->update(['kondisi_ruang' => $request->kondisi_ruang]);
            return response()->json('Data ruang sukses diupdate', 200);
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
        $ruang = Room::findOrFail($id);
        $image_path = public_path("images/ruang/".$ruang->foto_ruang);

        if(file_exists($image_path)){
            //File::delete($image_path);
            File::delete( $image_path);
        }
        $ruang->delete();
        return response()->json('Data Ruang dihapus', 200);
    }
}
